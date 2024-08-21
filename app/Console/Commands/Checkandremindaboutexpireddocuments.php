<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\DocumentsExpired;

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
        //go through each user, check for expired documents and send email reminders
        $userswithexpireddocuments = [];
        $users = User::all();
        foreach ($users as $user) {
            $cl = $user->fileUploads()->where('document_type', 'clinical_license')->orderby('date', 'desc')->first();
            if ($cl && $cl->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired clinical license that expired on " . $cl->date . "\n";
                $userswithexpireddocuments[$user] = 'clinical license, ';
            }
            $photographic_id = $user->fileUploads()->where('document_type', 'photographic_id')->orderby('date', 'desc')->first();
            if ($photographic_id && $photographic_id->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired photographic id that expired on " . $photographic_id->date . "\n";
                $userswithexpireddocuments[$user] = 'photographic id, ';
            }
            $w9 = $user->fileUploads()->where('document_type', 'W9')->orderby('date', 'desc')->first();
            if ($w9 && $w9->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired W9 that expired on " . $w9->date . "\n";
                $userswithexpireddocuments[$user] = 'W9, ';
            }
            $w8ben = $user->fileUploads()->where('document_type', 'W8BEN')->orderby('date', 'desc')->first();
            if ($w8ben && $w8ben->date < now()) {
                //$user->notify(new DocumentsExpired());
                //print "User " . $user->name . " has an expired W8BEN that expired on " . $w8ben->date . "\n";
                $userswithexpireddocuments[$user] = 'W8BEN, ';
            }
        }
        foreach ($userswithexpireddocuments as $user => $documents) {
            //$user->notify(new DocumentsExpired(rtrim($documents)));
            print("User " . $user->name . " has expired documents: " . rtrim($documents) . "\n");
        }
    }
}
