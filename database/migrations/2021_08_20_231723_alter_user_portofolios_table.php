<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserPortofoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_portofolios', function (Blueprint $table) {
            $table->string('contract_number', 50)->unique()->nullable()->after('quota');
            $table->string('cbc_file')->nullable()->after('contract_number');
            $table->string('certificate_file')->nullable()->after('cbc_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_portofolios', function (Blueprint $table) {
            $table->dropColumn(['contract_number','cbc_file','certificate_file']);
        });
    }
}
