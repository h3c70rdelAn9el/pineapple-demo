<?php

namespace App\Console;

use App\Mail\ClientWaitinglistTouchbase;
use App\Models\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:checkandremindaboutexpireddocuments')->weekly();

        $schedule->call(function () {
            $clients = Client::whereIn('user_id', [0, 200])
                ->where('waitlist', 1)
                ->where('updated_at', '<', now()->subWeeks(2))
                ->get();
            $log_message = '';
            foreach ($clients as $client) {
                try {

                    Mail::to($client->email)->send(new ClientWaitinglistTouchbase($client->preferred_name));

                    $client->update(['updated_at' => now()]);
                    $client->touch();
                    $client->save();

                    $log_message .= "Email waitinglist touch base sent to client ID {$client->id} at {$client->email}\n";
                } catch (\Exception $e) {
                    Log::error("Failed to send email to client ID {$client->id}: ".$e->getMessage());
                }
            }
            Log::error($log_message);
        })->daily();

        $schedule->command('invoices:generate-therapists')->monthlyOn(1, '02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
