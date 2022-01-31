<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPortofoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_portofolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('project_id')->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('project_batch_id')->foreign('project_batch_id')->references('id')->on('project_batches')->onDelete('cascade');
            $table->unsignedBigInteger('lot');
            $table->unsignedDouble('nominal');
            $table->unsignedDouble('return_nominal')->nullable();
            $table->unsignedInteger('quota')->default(0);
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
        Schema::dropIfExists('user_portofolios');
    }
}
