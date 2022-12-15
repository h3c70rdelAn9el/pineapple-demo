<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('therapy_sessions', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            // $table
            //     ->foreign('client_id')
            //     ->references('id')
            //     ->on('clients')
            //     ->onDelete('cascade');
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
            $table->dropColumn('client_id');
        });
    }
};
