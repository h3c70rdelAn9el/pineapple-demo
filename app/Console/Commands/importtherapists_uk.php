<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class importtherapists_uk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importtherapists:uk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import therapists uk from csv';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //open the file therapists-us.csv and import each row into a user model record

        //open the file
        $row = 1;
        if (($handle = fopen("therapists-uk.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {
                //print_r($data);
                //$num = count($data);
                if($row == 1)
                {
                    $row++;
                    continue;
                }
/*
                [0] => ﻿Name
                [1] => Registered
                [2] => Address
                [3] => Email
                [4] => £
                [5] => Gender
                [6] => ID
                [7] => Clinical License
                [8] => Clinical License Board
                [9] => Annual Contact about Complaints
                [10] => Response
                [11] => Insurance
                [12] => Signed Documents
                [13] => Leah Signed
                [14] => Number of Potential Clients
                [15] => Space for New Clients
                [16] => Coaching
                [17] => W8BEN/ E
                [18] => Voided Cheque
                [19] => Headshot
                [20] => Bio
                [21] => Website
                [22] => Dropbox
                [23] => Quickbook
                [24] => Client Extensions
                [25] => Notes
            
    */
                //create new user from $data
                $email = explode(" ", $data[3]);
                $user = \App\Models\User::firstOrNew(['email' => $email[0]]);
                $user->name = $data[0];
                $user->email = $email[0];
                //$user->password = \Hash::make('password');
                $user->country = $data[2];
                
                
                $user->gender = $data[5];
                $user->clinical_license = $data[7];
                $user->state_license_board = $data[8];
                $user->annual_contact_about_complaints_uk_date = $data[9];
                $user->response = $data[10];
                $user->insurance = $data[11];
                $user->signed_documents = $data[12];
                $user->leah_signed = $data[13];
                $user->number_of_potential_clients = $data[14];
                $user->space_for_new_clients = $data[15];
                $user->out_of_state_coaching = $data[16];
                
                $user->headshot = $data[19];
                $user->voided_cheque = $data[18];
                $user->bio = $data[20];
                $user->website = $data[21];
                $user->quickbooks = $data[23];
                $user->dropbox = $data[22];
                $user->client_extensions = $data[24];
                $user->notes = $data[25];
               


                $user->save();

                $row++;
            }  
        
            
            fclose($handle);
        }

        return Command::SUCCESS;
    }
}
