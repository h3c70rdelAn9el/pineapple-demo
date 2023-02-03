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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('legal_name')->nullable()->before('preferred_name');
            $table->string('sexual_orientation')->nullable()->after('pronouns');
            $table->string('ethnic_group')->nullable()->after('preferred_name');
            $table->string('home_address_line_1')->nullable()->after('ethnic_group');
            $table->string('home_address_line_2')->nullable()->after('home_address_line_1');
            $table->string('home_address_city')->nullable()->after('home_address_line_2');
            $table->string('home_address_state')->nullable()->after('home_address_city');
            $table->string('home_address_zip')->nullable()->after('home_address_state');
            $table->string('home_address_country')->nullable()->after('home_address_zip');
            $table->string('health_coverage_provider')->nullable();
            $table->string('health_coverage_number')->nullable()->after('health_coverage_provider');
            $table->date('health_coverage_expiration')->nullable()->after('health_coverage_number');
            $table->boolean('previous_therapy')->default(false)->after('health_coverage_number');
            $table->string('possible_support_needed')->nullable()->nullable()->after('previous_therapy');
            $table->string('preferred_language')->nullable()->after('possible_support_needed');
            $table->text('additional_notes')->nullable()->after('preferred_language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            // write the down() methods to reverse the changes made in the up() methods for each column
            $table->dropColumn('legal_name');
            $table->dropColumn('sexual_orientation');
            $table->dropColumn('ethnic_group');
            $table->dropColumn('home_address_line_1');
            $table->dropColumn('home_address_line_2');
            $table->dropColumn('home_address_city');
            $table->dropColumn('home_address_state');
            $table->dropColumn('home_address_zip');
            $table->dropColumn('home_address_country');
            $table->dropColumn('health_coverage_provider');
            $table->dropColumn('health_coverage_number');
            $table->dropColumn('health_coverage_expiration');
            $table->dropColumn('previous_therapy');
            $table->dropColumn('possible_support_needed');
            $table->dropColumn('preferred_language');
            $table->dropColumn('additional_notes');
        });
    }
};
