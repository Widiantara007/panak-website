<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->unsignedInteger('batch_no');
            $table->unsignedDouble('minimum_fund')->nullable();
            $table->unsignedDouble('maximum_fund')->nullable();
            $table->unsignedDouble('target_nominal')->nullable();
            $table->unsignedBigInteger('lot')->nullable();
            $table->float('roi_low')->nullable();
            $table->float('roi_high')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['draft','funding','ongoing','paid','closed']);
            $table->unsignedDouble('gross_income')->nullable();
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
        Schema::dropIfExists('project_batches');
    }
}
