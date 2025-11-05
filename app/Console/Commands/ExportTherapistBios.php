<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportTherapistBios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'therapists:export-bios {--output=therapist-bios.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export therapist names, emails, bio text, and licensed states to CSV';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Exporting therapist bios...');

        // Get all therapists (non-admin users)
        $therapists = User::where('admin', '!=', 1)
            ->with('fileUploads')
            ->orderBy('name')
            ->get();

        $outputFile = $this->option('output');
        $handle = fopen($outputFile, 'w');

        if (! $handle) {
            $this->error("Failed to create output file: {$outputFile}");

            return 1;
        }

        // Write CSV header
        fputcsv($handle, [
            'Name',
            'Preferred Name',
            'Email',
            'Bio Text',
            'Licensed States',
            'Bio File Path',
        ]);

        $progressBar = $this->output->createProgressBar($therapists->count());
        $progressBar->start();

        $stats = [
            'total' => 0,
            'with_bio' => 0,
            'with_licenses' => 0,
            'bio_errors' => 0,
        ];

        foreach ($therapists as $therapist) {
            $stats['total']++;
            $bioText = '';
            $bioFilePath = '';

            // Find bio file upload
            $bioFile = $therapist->fileUploads()
                ->where('document_type', 'Bio')
                ->first();

            if ($bioFile) {
                $bioFilePath = $bioFile->file_path;
                $bioText = $this->extractTextFromFile($bioFile->file_path, $bioFile->file_name);

                if (! str_contains($bioText, '[Error') && ! str_contains($bioText, '[File not found]')) {
                    $stats['with_bio']++;
                } else {
                    $stats['bio_errors']++;
                }
            }

            // Get licensed states from clinical license file uploads
            $licensedStates = $therapist->fileUploads()
                ->where('document_type', 'clinical_license')
                ->whereNotNull('region')
                ->pluck('region')
                ->unique()
                ->sort()
                ->implode(', ');

            if (! empty($licensedStates)) {
                $stats['with_licenses']++;
            }

            // Write row to CSV
            fputcsv($handle, [
                $therapist->name ?? '',
                $therapist->preferred_name ?? '',
                $therapist->email ?? '',
                $bioText,
                $licensedStates,
                $bioFilePath,
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        fclose($handle);

        // Display summary
        $this->info("Successfully exported {$stats['total']} therapists to {$outputFile}");
        $this->newLine();
        $this->line('Summary:');
        $this->line("  - Therapists with bios: {$stats['with_bio']}");
        $this->line("  - Therapists with licensed states: {$stats['with_licenses']}");
        if ($stats['bio_errors'] > 0) {
            $this->warn("  - Bio extraction errors: {$stats['bio_errors']} (check CSV for details)");
        }

        return 0;
    }

    /**
     * Extract text from PDF or Word document
     */
    private function extractTextFromFile(string $filePath, ?string $fileName = null): string
    {
        // Combine file_path and file_name to get the complete path
        if ($fileName) {
            $completePath = rtrim($filePath, '/').'/'.$fileName;
        } else {
            $completePath = $filePath;
        }

        // Check if file exists in Storage (works for S3, local, etc.)
        if (! Storage::exists($completePath)) {
            return '[File not found in storage: '.$completePath.']';
        }

        // Use file_name to determine extension if provided, otherwise use complete path
        $fileToCheck = $fileName ?: $completePath;
        $extension = strtolower(pathinfo($fileToCheck, PATHINFO_EXTENSION));

        // For unsupported formats, return early
        if (! in_array($extension, ['pdf', 'doc', 'docx', 'txt'])) {
            return "[Unsupported file format: {$extension}]";
        }

        try {
            // Download file from storage to a temporary location
            $tempPath = sys_get_temp_dir().'/'.uniqid('bio_export_').'.'.$extension;
            $fileContents = Storage::get($completePath);
            file_put_contents($tempPath, $fileContents);

            // Extract text based on file type
            $text = '';
            switch ($extension) {
                case 'pdf':
                    $text = $this->extractTextFromPdf($tempPath);
                    break;
                case 'doc':
                case 'docx':
                    $text = $this->extractTextFromWord($tempPath);
                    break;
                case 'txt':
                    $text = $fileContents;
                    break;
            }

            // Clean up temporary file
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }

            return $text;
        } catch (\Exception $e) {
            return "[Error reading file: {$e->getMessage()}]";
        }
    }

    /**
     * Extract text from PDF file
     */
    private function extractTextFromPdf(string $filePath): string
    {
        // Check if smalot/pdfparser is available
        if (! class_exists(\Smalot\PdfParser\Parser::class)) {
            return '[PDF parser not installed. Run: composer require smalot/pdfparser]';
        }

        try {
            $parser = new \Smalot\PdfParser\Parser;
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            // Clean up the text
            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);

            return $text;
        } catch (\Exception $e) {
            return "[Error parsing PDF: {$e->getMessage()}]";
        }
    }

    /**
     * Extract text from Word document
     */
    private function extractTextFromWord(string $filePath): string
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($extension === 'docx') {
            // Check if PhpOffice/PhpWord is available
            if (! class_exists(\PhpOffice\PhpWord\IOFactory::class)) {
                return '[PhpWord not installed. Run: composer require phpoffice/phpword]';
            }

            try {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                $text = '';

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText().' ';
                        } elseif (method_exists($element, 'getElements')) {
                            foreach ($element->getElements() as $childElement) {
                                if (method_exists($childElement, 'getText')) {
                                    $text .= $childElement->getText().' ';
                                }
                            }
                        }
                    }
                }

                // Clean up the text
                $text = preg_replace('/\s+/', ' ', $text);
                $text = trim($text);

                return $text;
            } catch (\Exception $e) {
                return "[Error parsing DOCX: {$e->getMessage()}]";
            }
        } else {
            // .doc format is more difficult, requires antiword or similar
            return '[.doc format not supported. Please convert to .docx or PDF]';
        }
    }
}
