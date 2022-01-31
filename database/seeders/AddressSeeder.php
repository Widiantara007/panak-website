<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = Address::all();
        if($addresses == '[]'){
            $path = base_path() . '/database/seeders/wilayah_2020.sql';
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }
        
    }
}
