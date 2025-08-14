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
            $table->string('title')->nullable();
            $table->string('preferred_name')->nullable()->after('name');
            $table->boolean('intern')->default(false)->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('street_address')->nullable();
            $table->string('zip_code_postal_code')->nullable();
            $table->string('iban_swift_code')->nullable();
            $table->boolean('contract_signed')->default(false)->nullable();
            $table->string('all_documents')->nullable();
            $table->boolean('full')->default(false)->nullable();
            $table->unsignedDecimal('session_cost', 10, 2)->nullable();
            $table->boolean('contact_for_promotionals')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('preferred_name');
            $table->dropColumn('intern');
            $table->dropColumn('supervisor_name');
            $table->dropColumn('street_address');
            $table->dropColumn('zip_code_postal_code');
            $table->dropColumn('iban_swift_code');
            $table->dropColumn('contract_signed');
            $table->dropColumn('all_documents');
            $table->dropColumn('full');
            $table->dropColumn('session_cost');
            $table->dropColumn('contact_for_promotionals');
        });
    }
};
