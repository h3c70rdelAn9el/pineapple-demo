<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class importtherapists_us extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importtherapists:us';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import therapists us from csv';

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
        if (($handle = fopen('therapists-us.csv', 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                //print_r($data);
                //$num = count($data);
                if ($row == 1) {
                    $row++;

                    continue;
                }

                /*
                    [0] => Name
                    [1] => Registered
                    [2] => State
                    [3] => Time Zone
                    [4] => County
                    [5] => Email
                    [6] => ID
                    [7] => Gender
                    [8] => $
                    [9] => Clinical License
                    [10] => State License Board
                    [11] => Annual Contact about  Complaints UK date
                    [12] => Response
                    [13] => Second State License
                    [14] => Date
                    [15] => State License Board
                    [16] => Annual Contact about  Complaints
                    [17] => Response
                    [18] => State License 3
                    [19] => Date
                    [20] => License Board
                    [21] => Annual contact about complaints
                    [22] => Response
                    [23] => State License 4
                    [24] => Date
                    [25] => License Board
                    [26] => Annual Contact about complaints
                    [27] => Response
                    [28] => State License 5
                    [29] => Date
                    [30] => License Board
                    [31] => Annual Contact about Complaints
                    [32] => Response
                    [33] => Insurance
                    [34] => Signed Documents
                    [35] => Leah Signed
                    [36] => Number of Potential Clients
                    [37] => Space for New clients
                    [38] => Out of State Coaching
                    [39] => W9
                    [40] => Headshot
                    [41] => Voided Cheque
                    [42] => BIO
                    [43] => Website
                    [44] => Quickbooks
                    [45] => Dropbox
                    [46] => Client Extensions
                    [47] => NOTES
                    [48] => COVID FUNDRAISER
                    */
                //create new user from $data
                $email = explode(' ', $data[5]);
                $user = \App\Models\User::firstOrNew(['email' => $email[0]]);
                $user->name = $data[0];
                $user->email = $email[0];
                //$user->password = \Hash::make('password');
                $user->country = 'US';
                $user->state = $data[2];
                $user->time_zone = $data[3];
                $user->county = $data[4];
                $user->gender = $data[7];
                $user->clinical_license = $data[9];
                $user->state_license_board = $data[10];
                $user->annual_contact_about_complaints_uk_date = $data[11];
                $user->response = $data[12];
                $user->insurance = $data[33];
                $user->signed_documents = $data[34];
                $user->leah_signed = $data[35];
                $user->number_of_potential_clients = $data[36];
                $user->space_for_new_clients = $data[37];
                $user->out_of_state_coaching = $data[38];
                $user->w9 = $data[39];
                $user->headshot = $data[40];
                $user->voided_cheque = $data[41];
                $user->bio = $data[42];
                $user->website = $data[43];
                $user->quickbooks = $data[44];
                $user->dropbox = $data[45];
                $user->client_extensions = $data[46];
                $user->notes = $data[47];
                $user->covid_fundraise = $data[48];

                $user->save();

                $row++;
            }

            fclose($handle);
        }

        return Command::SUCCESS;
    }
}
