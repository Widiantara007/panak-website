<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('nominal');
            $table->string('status')->nullable()->comment('pending/success/failed')->after('payment_method');
            $table->foreignId('project_batch_id')->nullable()->after('order_id')->foreign('project_batch_id')->references('id')->on('project_batches')->onDelete('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['project_batch_id']);
            $table->dropColumn(['payment_method','status','project_batch_id']);
        });
    }
}
