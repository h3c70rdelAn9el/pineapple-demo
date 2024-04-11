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
            $table->boolean('id_uploaded')->default(false);
            $table->boolean('W9_or_WBEN_uploaded')->default(false);
            $table->boolean('license_uploaded')->default(false);
            $table->boolean('insurance_uploaded')->default(false);
            $table->boolean('headshot_uploaded')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_uploaded');
            $table->dropColumn('W9_or_WBEN_uploaded');
            $table->dropColumn('license_uploaded');
            $table->dropColumn('insurance_uploaded');
            $table->dropColumn('headshot_uploaded');
        });
    }
};
