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
        Schema::table('clients', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['user_id']);
            
            // Make user_id nullable
            $table->bigInteger('user_id')->unsigned()->nullable()->change();
            
            // Re-add the foreign key constraint with onDelete set null
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Make user_id non-nullable again (set existing nulls to a default value first if needed)
            $table->bigInteger('user_id')->unsigned()->nullable(false)->change();
            
            // Re-add the original foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
