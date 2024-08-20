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
        $users = User::all();
        foreach ($users as $user) {
            $cl = $user->fileUploads()->where('document_type', 'clinical_license')->orderby('date', 'desc')->first();
            if ($cl && $cl->date < now()) {
                //$user->notify(new DocumentsExpired());
                print "User " . $user->name . " has an expired clinical license that expired on " . $cl->date . "\n";
            }
        }
    }
}
