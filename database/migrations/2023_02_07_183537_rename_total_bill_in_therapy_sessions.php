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
            $table->renameColumn('total_bill', 'session_cost');
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
            $table->renameColumn('session_cost', 'total_bill');
        });
    }
};
