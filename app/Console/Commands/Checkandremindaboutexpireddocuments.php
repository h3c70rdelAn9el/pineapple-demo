<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\DocumentsExpired;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Checkandremindaboutexpireddocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checkandremindaboutexpireddocuments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired documents and send email reminders to the users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log the start of the command execution
        Log::channel('discord')->info('🔍 **Document Expiry Check Started**', [
            'command' => 'Checkandremindaboutexpireddocuments',
            'timestamp' => now()->toDateTimeString(),
            'environment' => config('app.env')
        ]);

        //go through each user, check for expired documents and send email reminders
        $userswithexpireddocuments = [];
        $users = User::where('active_status', 0)->get();
        foreach ($users as $user) {
            $cl = $user->fileUploads()->where('document_type', 'clinical_license')->orderby('date', 'desc')->first();
            if ($cl && $cl->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired clinical license that expired on " . $cl->date . "\n";
                $userswithexpireddocuments[$user->id] = 'clinical license, ';
            }
            $photographic_id = $user->fileUploads()->where('document_type', 'photographic_id')->orderby('date', 'desc')->first();
            if ($photographic_id && $photographic_id->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired photographic id that expired on " . $photographic_id->date . "\n";
                $userswithexpireddocuments[$user->id] = 'photographic id, ';
            }
            /*
            $w9 = $user->fileUploads()->where('document_type', 'W9')->orderby('date', 'desc')->first();
            if ($w9 && $w9->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired W9 that expired on " . $w9->date . "\n";
                $userswithexpireddocuments[$user->id] = 'W9, ';
            }
            $w8ben = $user->fileUploads()->where('document_type', 'W8BEN')->orderby('date', 'desc')->first();
            if ($w8ben && $w8ben->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired W8BEN that expired on " . $w8ben->date . "\n";
                $userswithexpireddocuments[$user->id] = 'W8BEN, ';
            }
                */
            $w9 = $user->isW9Uploaded();
            if ($w9) {
                $userswithexpireddocuments[$user->id] = 'W9 or W8BEN, ';
            }
        }
        
        // Log details about notifications sent
        if (count($userswithexpireddocuments) > 0) {
            $notifiedTherapists = [];
            
            foreach ($userswithexpireddocuments as $userid => $documents) {
                $user = User::find($userid);
                $user->notify(new DocumentsExpired(rtrim($documents)));
                print("User " . $user->name . " has expired documents: " . rtrim($documents) . "\n");
                
                $notifiedTherapists[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'expired_documents' => rtrim($documents, ', ')
                ];
            }
            
            // Log to Discord with details of notified therapists
            Log::channel('discord')->warning('📧 **Document Expiry Notifications Sent**', [
                'command' => 'Checkandremindaboutexpireddocuments',
                'total_notifications' => count($userswithexpireddocuments),
                'therapists_notified' => $notifiedTherapists,
                'timestamp' => now()->toDateTimeString()
            ]);
        } else {
            // Log when no expired documents are found
            Log::channel('discord')->info('✅ **No Expired Documents Found**', [
                'command' => 'Checkandremindaboutexpireddocuments',
                'total_users_checked' => $users->count(),
                'timestamp' => now()->toDateTimeString()
            ]);
        }
        
        // Log the completion of the command
        Log::channel('discord')->info('🏁 **Document Expiry Check Completed**', [
            'command' => 'Checkandremindaboutexpireddocuments',
            'total_users_checked' => $users->count(),
            'notifications_sent' => count($userswithexpireddocuments),
            'duration' => 'Command completed',
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
