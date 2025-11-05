<?php

namespace Tests\Unit;

use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExportTherapistBiosCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_runs_successfully(): void
    {
        // Create a test therapist
        User::factory()->create([
            'admin' => 0,
            'name' => 'Test Therapist',
            'email' => 'test@example.com',
        ]);

        $outputFile = 'test-export.csv';

        // Run the command
        $exitCode = Artisan::call('therapists:export-bios', [
            '--output' => $outputFile,
        ]);

        // Assert command ran successfully
        $this->assertEquals(0, $exitCode);

        // Assert file was created
        $this->assertFileExists($outputFile);

        // Read and verify CSV content
        $csvContent = array_map('str_getcsv', file($outputFile));
        $headers = $csvContent[0];

        // Verify headers
        $this->assertEquals('Name', $headers[0]);
        $this->assertEquals('Preferred Name', $headers[1]);
        $this->assertEquals('Email', $headers[2]);
        $this->assertEquals('Bio Text', $headers[3]);
        $this->assertEquals('Licensed States', $headers[4]);
        $this->assertEquals('Bio File Path', $headers[5]);

        // Verify at least one therapist row exists
        $this->assertGreaterThanOrEqual(2, count($csvContent));

        // Clean up
        unlink($outputFile);
    }

    public function test_command_excludes_admin_users(): void
    {
        // Create an admin user
        User::factory()->create([
            'admin' => 1,
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create a therapist
        User::factory()->create([
            'admin' => 0,
            'name' => 'Therapist User',
            'email' => 'therapist@example.com',
        ]);

        $outputFile = 'test-export-admin.csv';

        // Run the command
        Artisan::call('therapists:export-bios', [
            '--output' => $outputFile,
        ]);

        // Read CSV content
        $csvContent = array_map('str_getcsv', file($outputFile));

        // Should have header + 1 therapist row (not admin)
        $this->assertEquals(2, count($csvContent));

        // Verify the therapist is in the export, not the admin
        $this->assertStringContainsString('Therapist User', file_get_contents($outputFile));
        $this->assertStringNotContainsString('Admin User', file_get_contents($outputFile));

        // Clean up
        unlink($outputFile);
    }

    public function test_extracts_bio_text_from_file(): void
    {
        Storage::fake('local');

        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'name' => 'Bio Test Therapist',
            'email' => 'biotest@example.com',
        ]);

        // Create a text bio file
        $bioContent = 'This is a test bio for the therapist with extensive experience.';
        Storage::put('bios/test-bio.txt', $bioContent);

        // Create file upload record - file_path is directory, file_name is the actual filename
        FileUpload::create([
            'user_id' => $therapist->id,
            'file_path' => 'bios/',
            'file_name' => 'test-bio.txt',
            'document_type' => 'Bio',
        ]);

        $outputFile = 'test-bio-export.csv';

        // Run the command
        Artisan::call('therapists:export-bios', [
            '--output' => $outputFile,
        ]);

        // Read CSV content
        $csvContent = file_get_contents($outputFile);

        // Verify bio text was extracted
        $this->assertStringContainsString($bioContent, $csvContent);

        // Clean up
        unlink($outputFile);
    }

    public function test_detects_file_extension_from_filename(): void
    {
        Storage::fake('local');

        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'name' => 'Extension Test',
            'email' => 'extension@example.com',
        ]);

        // Create a bio file where file_path doesn't have extension but file_name does
        Storage::put('uploads/12345/therapist-bio.txt', 'Bio text content');

        // Create file upload record with file_name having extension
        FileUpload::create([
            'user_id' => $therapist->id,
            'file_path' => 'uploads/12345/',
            'file_name' => 'therapist-bio.txt',
            'document_type' => 'Bio',
        ]);

        $outputFile = 'test-extension-export.csv';

        // Run the command
        Artisan::call('therapists:export-bios', [
            '--output' => $outputFile,
        ]);

        // Read CSV content
        $csvContent = file_get_contents($outputFile);

        // Should extract text successfully, not show unsupported format
        $this->assertStringContainsString('Bio text content', $csvContent);
        $this->assertStringNotContainsString('[Unsupported file format', $csvContent);

        // Clean up
        unlink($outputFile);
    }

    public function test_collects_licensed_states(): void
    {
        // Create a therapist
        $therapist = User::factory()->create([
            'admin' => 0,
            'name' => 'Multi State Therapist',
            'email' => 'multistate@example.com',
        ]);

        // Create clinical license file uploads with different states
        FileUpload::create([
            'user_id' => $therapist->id,
            'file_path' => 'licenses/ca-license.pdf',
            'file_name' => 'california-license.pdf',
            'document_type' => 'clinical_license',
            'region' => 'California',
        ]);

        FileUpload::create([
            'user_id' => $therapist->id,
            'file_path' => 'licenses/ny-license.pdf',
            'file_name' => 'new-york-license.pdf',
            'document_type' => 'clinical_license',
            'region' => 'New York',
        ]);

        $outputFile = 'test-states-export.csv';

        // Run the command
        Artisan::call('therapists:export-bios', [
            '--output' => $outputFile,
        ]);

        // Read CSV content
        $csvContent = file_get_contents($outputFile);

        // Verify both states are present (sorted alphabetically)
        $this->assertStringContainsString('California, New York', $csvContent);

        // Clean up
        unlink($outputFile);
    }
}
