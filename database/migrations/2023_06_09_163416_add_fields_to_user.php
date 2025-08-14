<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            // Registered ,State,Time Zone,County,Email,ID,Gender,$,Clinical License,State License Board ,Annual Contact about  Complaints UK date,Response,Second State License ,Date,State License Board,Annual Contact about  Complaints,Response,State License 3,Date,License Board,Annual contact about complaints,Response,State License 4,Date,License Board,Annual Contact about complaints ,Response,State License 5,Date,License Board,Annual Contact about Complaints,Response,Insurance ,Signed Documents,Leah Signed,Number of Potential Clients,Space for New clients,Out of State Coaching,W9,Headshot,Voided Cheque,BIO,Website,Quickbooks,Dropbox,Client Extensions,NOTES,COVID FUNDRAISE
            $table->string('country')->nullable();
            $table->string('registered')->nullable();
            $table->string('state')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('county')->nullable();

            $table->string('gender')->nullable();
            $table->string('clinical_license')->nullable();
            $table->string('state_license_board')->nullable();
            $table->string('annual_contact_about_complaints_uk_date')->nullable();
            $table->string('response')->nullable();
            /*
            $table->string('second_state_license')->nullable();
            $table->string('date')->nullable();
            $table->string('state_license_board')->nullable();
            $table->string('annual_contact_about_complaints')->nullable();
            $table->string('response')->nullable();
            $table->string('state_license_3')->nullable();
            $table->string('date')->nullable();
            $table->string('license_board')->nullable();
            $table->string('annual_contact_about_complaints')->nullable();
            $table->string('response')->nullable();
            $table->string('state_license_4')->nullable();
            $table->string('date')->nullable();
            $table->string('license_board')->nullable();
            $table->string('annual_contact_about_complaints')->nullable();
            $table->string('response')->nullable();
            $table->string('state_license_5')->nullable();
            $table->string('date')->nullable();
            $table->string('license_board')->nullable();
            $table->string('annual_contact_about_complaints')->nullable();
            $table->string('response')->nullable();
            */
            $table->string('insurance')->nullable();
            $table->string('signed_documents')->nullable();
            $table->string('leah_signed')->nullable();
            $table->string('number_of_potential_clients')->nullable();
            $table->string('space_for_new_clients')->nullable();
            $table->string('out_of_state_coaching')->nullable();
            $table->string('w9')->nullable();
            $table->string('headshot')->nullable();
            $table->string('voided_cheque')->nullable();
            $table->string('bio')->nullable();
            $table->string('website')->nullable();
            $table->string('quickbooks')->nullable();
            $table->string('dropbox')->nullable();
            $table->string('client_extensions')->nullable();
            $table->string('notes')->nullable();
            $table->string('covid_fundraise')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
};
