<?php

namespace Tests\Feature;

use App\Console\Commands\GenerateMonthlyTherapistInvoices;
use App\Models\Client;
use App\Models\TherapySession;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class GenerateMonthlyTherapistInvoicesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_invoice_template_includes_banking_details_when_available(): void
    {
        // Create a therapist with banking details
        $therapist = User::factory()->create([
            'admin' => false,
            'active_status' => 0,
            'account_name' => 'John Doe Therapy Services',
            'bank_name' => 'Test Bank',
            'account_number' => '1234567890',
            'routing_number' => '123456789',
            'iban_swift_code' => 'TESTBANK123',
            'session_cost' => 100.00,
        ]);

        // Create a client
        $client = Client::factory()->create([
            'user_id' => $therapist->id,
            'client_code' => 'CLIENT001',
        ]);

        // Create a therapy session from last month
        $lastMonth = Carbon::now()->subMonth();
        $session = TherapySession::factory()->create([
            'user_id' => $therapist->id,
            'client_id' => $client->id,
            'session_cost' => 100.00,
            'client_contribution' => 20.00,
            'remaining_client_contribution' => 80.00,
            'created_at' => $lastMonth,
        ]);

        // Test the PDF generation with banking details
        $sessionSummary = [
            [
                'client_id' => $client->id,
                'client_code' => $client->client_code,
                'quantity' => 1,
                'sessions' => collect([$session]),
                'total_session_cost' => 100.00,
                'total_client_contribution' => 20.00,
                'total_remaining_contribution' => 80.00,
            ]
        ];

        $invoiceNumber = 'INV-' . $therapist->id . '-' . Carbon::now()->format('Ym');
        $invoiceDate = Carbon::now()->format('Y-m-d');
        $period = [$lastMonth->startOfMonth()->format('Y-m-d'), $lastMonth->endOfMonth()->format('Y-m-d')];

        // Generate the PDF and check its content
        $pdf = Pdf::loadView('invoices.therapist', [
            'therapist' => $therapist,
            'sessionSummary' => $sessionSummary,
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'period' => $period,
        ]);

        $pdfContent = $pdf->output();

        // Convert PDF to string for content checking (simplified approach)
        // Note: In a real test, you might want to use a PDF text extraction library
        $this->assertNotEmpty($pdfContent);

        // Test the view directly to check banking details are included
        $view = view('invoices.therapist', [
            'therapist' => $therapist,
            'sessionSummary' => $sessionSummary,
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'period' => $period,
        ])->render();

        // Assert banking details are present in the view
        $this->assertStringContainsString('Banking Details for Payment', $view);
        $this->assertStringContainsString('John Doe Therapy Services', $view);
        $this->assertStringContainsString('Test Bank', $view);
        $this->assertStringContainsString('1234567890', $view);
        $this->assertStringContainsString('123456789', $view);
        $this->assertStringContainsString('TESTBANK123', $view);
    }

    public function test_invoice_template_shows_message_when_banking_details_missing(): void
    {
        // Create a therapist without banking details
        $therapist = User::factory()->create([
            'admin' => false,
            'active_status' => 0,
            'session_cost' => 100.00,
            // No banking details set
        ]);

        $sessionSummary = [
            [
                'client_id' => 1,
                'client_code' => 'CLIENT001',
                'quantity' => 1,
                'total_session_cost' => 100.00,
                'total_client_contribution' => 20.00,
                'total_remaining_contribution' => 80.00,
            ]
        ];

        $invoiceNumber = 'INV-' . $therapist->id . '-' . Carbon::now()->format('Ym');
        $invoiceDate = Carbon::now()->format('Y-m-d');
        $period = [Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'), Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d')];

        // Test the view to check missing banking details message
        $view = view('invoices.therapist', [
            'therapist' => $therapist,
            'sessionSummary' => $sessionSummary,
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'period' => $period,
        ])->render();

        // Assert the "no banking details" message is present
        $this->assertStringContainsString('Banking Details for Payment', $view);
        $this->assertStringContainsString('Banking details not provided', $view);
        $this->assertStringContainsString('Please contact us to update your payment information', $view);
    }

    public function test_invoice_template_handles_partial_banking_details(): void
    {
        // Create a therapist with only some banking details
        $therapist = User::factory()->create([
            'admin' => false,
            'active_status' => 0,
            'account_name' => 'John Doe Therapy Services',
            'bank_name' => 'Test Bank',
            'session_cost' => 100.00,
            // Missing account_number, routing_number, iban_swift_code
        ]);

        $sessionSummary = [
            [
                'client_id' => 1,
                'client_code' => 'CLIENT001',
                'quantity' => 1,
                'total_session_cost' => 100.00,
                'total_client_contribution' => 20.00,
                'total_remaining_contribution' => 80.00,
            ]
        ];

        $invoiceNumber = 'INV-' . $therapist->id . '-' . Carbon::now()->format('Ym');
        $invoiceDate = Carbon::now()->format('Y-m-d');
        $period = [Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'), Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d')];

        // Test the view to check partial banking details
        $view = view('invoices.therapist', [
            'therapist' => $therapist,
            'sessionSummary' => $sessionSummary,
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'period' => $period,
        ])->render();

        // Assert the partial banking details are shown
        $this->assertStringContainsString('Banking Details for Payment', $view);
        $this->assertStringContainsString('John Doe Therapy Services', $view);
        $this->assertStringContainsString('Test Bank', $view);
        // Should not show the "not provided" message since some details exist
        $this->assertStringNotContainsString('Banking details not provided', $view);
    }
}
