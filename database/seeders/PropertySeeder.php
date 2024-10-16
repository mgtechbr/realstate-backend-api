<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use Faker\Factory as Faker;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $properties = [
            [
                'name' => 'Casa na Praia',
                'location' => 'Praia do Forte, Bahia',
                'price' => 500000.00,
                'description' => 'Uma linda casa de veraneio perto do mar.',
                'bathroom' => 2,
                'bedroom' => 3,
                'area' => 150.00,
                'type' => 'casa',
                'city_id' => 1,
                'state_id' => 1,
                'district_id' => 1,
                'image' => 'images/casa_praia.jpg',
            ],
            [
                'name' => 'Apartamento na Cidade',
                'location' => 'Centro, São Paulo',
                'price' => 350000.00,
                'description' => 'Apartamento moderno em uma localização privilegiada.',
                'bathroom' => 1,
                'bedroom' => 2,
                'area' => 80.00,
                'type' => 'apartamento',
                'city_id' => 1,
                'state_id' => 1,
                'district_id' => 1,
                'image' => 'images/apartamento_cidade.jpg',
            ],
            [
                'name' => 'Chácara no Interior',
                'location' => 'Campinas, São Paulo',
                'price' => 700000.00,
                'description' => 'Chácara com muito espaço e tranquilidade.',
                'bathroom' => 3,
                'bedroom' => 4,
                'area' => 300.00,
                'type' => 'casa',
                'city_id' => 1,
                'state_id' => 1,
                'district_id' => 1,
                'image' => 'images/chacara_interior.jpg',
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }

        for ($i = 0; $i < 10; $i++) {
            Property::create([
                'name' => $faker->sentence(3),
                'location' => $faker->address,
                'price' => $faker->randomFloat(2, 100000, 1000000),
                'description' => $faker->paragraph,
                'bathroom' => $faker->numberBetween(1, 5),
                'bedroom' => $faker->numberBetween(1, 5),
                'area' => $faker->randomFloat(2, 50, 500),
                'type' => $faker->randomElement(['casa', 'apartamento', 'terreno']),
                'city_id' => 1,
                'state_id' => 1,
                'district_id' => 1,
                'image' => 'images/default_image.jpg',
            ]);
        }
    }
}
