<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Property;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Criar propriedades de exemplo
        Category::create([
            'name' => 'Terrenos'
        ]);

        Category::create([
            'name' => 'Apartamentos'
        ]);

        Category::create([
            'name' => 'Casas'
        ]);

    }
}
