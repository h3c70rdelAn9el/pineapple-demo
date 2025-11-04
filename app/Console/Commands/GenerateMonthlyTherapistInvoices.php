<?php

namespace App\Console\Commands;

use App\Models\TherapySession;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GenerateMonthlyTherapistInvoices extends Command
{
    protected $signature = 'invoices:generate-therapists';

    protected $description = 'Generate and email PDF invoices for each active therapist with sessions in the previous month.';

    public function handle()
    {
        $now = Carbon::now();
        $start = $now->copy()->subMonth()->startOfMonth();
        $end = $now->copy()->subMonth()->endOfMonth();

        $therapists = User::where('admin', 0)
            ->where('active_status', 1)
            ->whereHas('therapy_sessions', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end]);
            })
            ->get();

        foreach ($therapists as $therapist) {
            $this->info("Processing therapist ID {$therapist->id} - {$therapist->email}");
            $sessions = TherapySession::with('client')
                ->where('user_id', $therapist->id)
                ->whereBetween('created_at', [$start, $end])
                ->orderBy('created_at')
                ->get();

            $this->info('Found '.count($sessions)." sessions for therapist ID {$therapist->id}");

            if ($sessions->isEmpty()) {
                continue;
            }

            $invoiceNumber = 'INV-'.$therapist->id.'-'.$now->format('Ym');
            $invoiceDate = $now->format('Y-m-d');

            $pdf = Pdf::loadView('invoices.therapist', [
                'therapist' => $therapist,
                'sessions' => $sessions,
                'invoiceNumber' => $invoiceNumber,
                'invoiceDate' => $invoiceDate,
                'period' => [$start->format('Y-m-d'), $end->format('Y-m-d')],
                'currencySymbol' => $this->getCurrencySymbol($therapist->currency),
            ]);

            $filename = 'Invoice_'.$therapist->id.'_'.$now->format('Ym').'.pdf';

            // Use invoice_email if set, otherwise fall back to regular email
            $therapistEmail = $therapist->invoice_email ?? $therapist->email;

            Mail::send('emails.therapist_invoice', [
                'therapist' => $therapist,
                'invoiceNumber' => $invoiceNumber,
                'invoiceDate' => $invoiceDate,
            ], function ($message) use ($pdf, $filename, $therapistEmail) {
                $message->to('kellie@pineapplesupport.org')
                    ->cc($therapistEmail)
                    ->subject('Therapist Invoice')
                    ->attachData($pdf->output(), $filename);
            });

            $this->info("Invoice sent to therapist ID {$therapist->id} at {$therapistEmail}");

        }

        $this->info('Monthly therapist invoices generated and sent.');
    }

    private function getCurrencySymbol(?string $currencyCode): string
    {
        $currencySymbols = [
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            'JPY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'CHF' => 'CHF',
            'CNY' => '¥',
            'SEK' => 'kr',
            'NZD' => 'NZ$',
            'MXN' => '$',
            'SGD' => 'S$',
            'HKD' => 'HK$',
            'NOK' => 'kr',
            'KRW' => '₩',
            'TRY' => '₺',
            'RUB' => '₽',
            'INR' => '₹',
            'BRL' => 'R$',
            'ZAR' => 'R',
            'PHP' => '₱',
            'CZK' => 'Kč',
        ];

        return $currencySymbols[$currencyCode] ?? '$'; // Default to $ (USD)
    }
}
