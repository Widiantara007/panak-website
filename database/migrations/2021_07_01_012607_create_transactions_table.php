<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type')->nullable()->comment('pasarnak/investnak/wallet');
            $table->enum('transaction_type', ['income','outcome']);
            $table->foreignId('order_id')->nullable()->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreignId('user_portofolio_id')->nullable()->foreign('user_portofolio_id')->references('id')->on('user_portofolios')->onDelete('cascade');
            $table->unsignedDouble('nominal');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
