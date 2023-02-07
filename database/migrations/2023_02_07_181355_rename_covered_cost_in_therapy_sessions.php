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
        Schema::table('therapy_sessions', function (Blueprint $table) {
            $table->renameColumn('covered_cost', 'client_contribution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('therapy_sessions', function (Blueprint $table) {
            $table->renameColumn('client_contribution', 'covered_cost');
        });
    }
};
