<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = Bank::all();
        if($banks == '[]'){
            $path = base_path() . '/database/seeders/bank.sql';
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }
    }
}
