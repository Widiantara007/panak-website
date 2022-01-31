<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('recipient_name')->nullable();
            $table->string('location_code');
            $table->string('address_detail');
            $table->string('postal_code');
            $table->string('no_hp');
            $table->string('status')->comment('payment, process, sending, received, done');
            $table->unsignedDouble('total')->nullable();
            $table->string('payment_type')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
