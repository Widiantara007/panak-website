<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsYearlyToProjectBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_batches', function (Blueprint $table) {
            $table->boolean('is_yearly')->default(false)->after('roi_high');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_batches', function (Blueprint $table) {
            $table->dropColumn('is_yearly');
            
        });
    }
}
