<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('verification_status')->nullable()->comment('process/accepted/rejected')->after('signature');
            $table->dateTime('verified_at')->nullable()->after('verification_status');
            $table->string('verification_feedback')->nullable()->after('verified_at');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn(['verification_status', 'verified_at', 'verification_feedback']);
        });
    }
}
