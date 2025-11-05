<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
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
}
