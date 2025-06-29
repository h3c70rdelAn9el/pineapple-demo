<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\TherapySession;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
            $sessions = TherapySession::where('user_id', $therapist->id)
            ->whereBetween('created_at', [$start, $end])
            ->get()
            ->groupBy('client_id');

            // Prepare session summary per client
            $sessionSummary = [];
            foreach ($sessions as $clientId => $clientSessions) {
            $client = $clientSessions->first()->client; // Assuming TherapySession has 'client' relationship

            // Calculate totals for this client
            $totalSessionCost = $clientSessions->sum('session_cost');
            $totalClientContribution = $clientSessions->sum('client_contribution');
            $totalRemainingContribution = $clientSessions->sum('remaining_client_contribution');

            $sessionSummary[] = [
                'client_id' => $clientId,
                'client_code' => $client ? $client->client_code : null,
                'quantity' => $clientSessions->count(),
                'sessions' => $clientSessions,
                'total_session_cost' => $totalSessionCost,
                'total_client_contribution' => $totalClientContribution,
                'total_remaining_contribution' => $totalRemainingContribution,
            ];
            }

            $this->info("Found " . count($sessionSummary) . " clients with sessions for therapist ID {$therapist->id}");

            if (empty($sessionSummary)) continue;

            $invoiceNumber = 'INV-' . $therapist->id . '-' . $now->format('Ym');
            $invoiceDate = $now->format('Y-m-d');

            $pdf = Pdf::loadView('invoices.therapist', [
                'therapist' => $therapist,
                'sessionSummary' => $sessionSummary,
                'invoiceNumber' => $invoiceNumber,
                'invoiceDate' => $invoiceDate,
                'period' => [$start->format('Y-m-d'), $end->format('Y-m-d')],
            ]);

            $filename = 'Invoice_' . $therapist->id . '_' . $now->format('Ym') . '.pdf';

            Mail::send('emails.therapist_invoice', [
                'therapist' => $therapist,
                'invoiceNumber' => $invoiceNumber,
                'invoiceDate' => $invoiceDate,
            ], function ($message) use ($pdf, $filename) {
                $message->to('kellie@pineapplesupport.org')
                    ->subject('Therapist Invoice')
                    ->attachData($pdf->output(), $filename);
            });
           
            $this->info("Invoice sent to therapist ID {$therapist->id} at {$therapist->email}");
            
        }

        $this->info('Monthly therapist invoices generated and sent.');
    }
}
