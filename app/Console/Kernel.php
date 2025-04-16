<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Client;
use App\Mail\ClientNoTherapistResponse;
use App\Mail\ClientWaitinglistTouchbase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:checkandremindaboutexpireddocuments')->weekly();

        $schedule->call(function () {
            $clients = Client::whereIn('user_id', [0, 200])
                ->where('updated_at', '<', now()->subWeeks(2))
                ->get();

            foreach ($clients as $client) {
                try {
                    Mail::to($client->email)->send(new ClientWaitinglistTouchbase($client->preferred_name));
                    $client->update(['updated_at' => now()]);
                } catch (\Exception $e) {
                    Log::error("Failed to send email to client ID {$client->id}: " . $e->getMessage());
                }
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
