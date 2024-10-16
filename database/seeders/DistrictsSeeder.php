<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsSeeder extends Seeder
{
    public function run()
    {
        DB::table('districts')->insert([
            ['name' => 'Centro', 'city_id' => 1],
            ['name' => 'Pituba', 'city_id' => 2],
            ['name' => 'Barra', 'city_id' => 2],
            ['name' => 'Jardim', 'city_id' => 3],
            ['name' => 'Savassi', 'city_id' => 4]
        ]);
    }
}
