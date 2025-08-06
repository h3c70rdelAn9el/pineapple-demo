<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\DocumentsExpired;
use App\Notifications\DocumentsMissing;
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
    protected $description = 'Check for expired and missing documents and send email reminders to the users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log the start of the command execution
        Log::channel('discord')->info('🔍 **Document Check Started**', [
            'command' => 'Checkandremindaboutexpireddocuments',
            'checking_for' => 'expired and missing documents',
            'timestamp' => now()->toDateTimeString(),
            'environment' => config('app.env')
        ]);

        //go through each user, check for expired documents and send email reminders
        $userswithexpireddocuments = [];
        $userswithmissingdocuments = [];
        $users = User::where('active_status', 0)->get();
        foreach ($users as $user) {
            $expiredDocs = '';
            $missingDocs = '';
            
            // Check for expired documents
            $cl = $user->fileUploads()->where('document_type', 'clinical_license')->orderby('date', 'desc')->first();
            if ($cl && $cl->date < now()) {
                $expiredDocs .= 'clinical license, ';
            } elseif (!$cl) {
                $missingDocs .= 'clinical license, ';
            }
            
            $photographic_id = $user->fileUploads()->where('document_type', 'photographic_id')->orderby('date', 'desc')->first();
            if ($photographic_id && $photographic_id->date < now()) {
                $expiredDocs .= 'photographic id, ';
            } elseif (!$photographic_id) {
                $missingDocs .= 'photographic id, ';
            }
            
            $public_insurance = $user->fileUploads()->where('document_type', 'public_liability_insurance')->orderby('date', 'desc')->first();
            if ($public_insurance && $public_insurance->date < now()) {
                $expiredDocs .= 'public liability insurance, ';
            } elseif (!$public_insurance) {
                $missingDocs .= 'public liability insurance, ';
            }
            
            // Check for headshot (no expiration)
            $headshot = $user->fileUploads()->where('document_type', 'headshot')->first();
            if (!$headshot) {
                $missingDocs .= 'headshot, ';
            }
            
            // Check W9/W8BEN (no expiration, but required)
            $w9 = $user->isW9Uploaded();
            if ($w9) {
                $expiredDocs .= 'W9 or W8BEN, ';
            } else {
                $missingDocs .= 'W9 or W8BEN, ';
            }
            
            // Store users with expired documents
            if (!empty($expiredDocs)) {
                $userswithexpireddocuments[$user->id] = $expiredDocs;
            }
            
            // Store users with missing documents
            if (!empty($missingDocs)) {
                $userswithmissingdocuments[$user->id] = $missingDocs;
            }
        }
        
        // Send notifications for expired documents
        $notifiedTherapists = [];
        if (count($userswithexpireddocuments) > 0) {
            foreach ($userswithexpireddocuments as $userid => $documents) {
                $user = User::find($userid);
                $user->notify(new DocumentsExpired(rtrim($documents, ', ')));
                print("User " . $user->name . " has expired documents: " . rtrim($documents, ', ') . "\n");
                
                $notifiedTherapists[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'issue_type' => 'expired',
                    'documents' => rtrim($documents, ', ')
                ];
            }
        }
        
        // Send notifications for missing documents
        if (count($userswithmissingdocuments) > 0) {
            foreach ($userswithmissingdocuments as $userid => $documents) {
                $user = User::find($userid);
                $user->notify(new DocumentsMissing(rtrim($documents, ', ')));
                print("User " . $user->name . " has missing documents: " . rtrim($documents, ', ') . "\n");
                
                $notifiedTherapists[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'issue_type' => 'missing',
                    'documents' => rtrim($documents, ', ')
                ];
            }
        }
        
        // Log details about notifications sent
        $totalNotifications = count($userswithexpireddocuments) + count($userswithmissingdocuments);
        if ($totalNotifications > 0) {
            // Log to Discord with details of notified therapists
            Log::channel('discord')->warning('📧 **Document Notifications Sent**', [
                'command' => 'Checkandremindaboutexpireddocuments',
                'total_notifications' => $totalNotifications,
                'expired_documents_notifications' => count($userswithexpireddocuments),
                'missing_documents_notifications' => count($userswithmissingdocuments),
                'therapists_notified' => $notifiedTherapists,
                'cc_recipient' => 'kellie@pineapplesupport.org',
                'timestamp' => now()->toDateTimeString()
            ]);
        } else {
            // Log when no issues are found
            Log::channel('discord')->info('✅ **No Document Issues Found**', [
                'command' => 'Checkandremindaboutexpireddocuments',
                'total_users_checked' => $users->count(),
                'timestamp' => now()->toDateTimeString()
            ]);
        }
        
        // Log the completion of the command
        Log::channel('discord')->info('🏁 **Document Check Completed**', [
            'command' => 'Checkandremindaboutexpireddocuments',
            'total_users_checked' => $users->count(),
            'expired_notifications_sent' => count($userswithexpireddocuments),
            'missing_notifications_sent' => count($userswithmissingdocuments),
            'total_notifications' => $totalNotifications,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
