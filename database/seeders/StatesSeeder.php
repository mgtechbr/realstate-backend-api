<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    public function run()
    {
        DB::table('states')->insert([
            ['name' => 'São Paulo'],
            ['name' => 'Bahia'],
            ['name' => 'Minas Gerais']
        ]);
    }
}
