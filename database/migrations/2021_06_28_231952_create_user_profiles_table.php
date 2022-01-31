<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('sex', ['male','female'])->nullable();
            $table->string('ktp_number',16)->unique()->nullable();
            $table->string('ktp_image')->nullable();
            $table->string('selfie_image')->nullable();
            $table->string('npwp_number',15)->unique()->nullable();
            $table->string('npwp_image')->nullable();
            $table->date('birthday')->nullable();
            $table->string('job')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
