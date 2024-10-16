<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'São Paulo', 'state_id' => 1],
            ['name' => 'Salvador', 'state_id' => 2],
            ['name' => 'Campinas', 'state_id' => 1],
            ['name' => 'Belo Horizonte', 'state_id' => 3]
        ]);
    }
}
