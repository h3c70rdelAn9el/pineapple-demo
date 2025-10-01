<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('therapist_contribution', 8, 2)->nullable()->after('session_cost');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->decimal('therapist_contribution', 8, 2)->nullable()->after('client_contribution');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('therapist_contribution');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('therapist_contribution');
        });
    }
};
