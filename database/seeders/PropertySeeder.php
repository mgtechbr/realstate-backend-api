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

        for ($i = 0; $i < 3; $i++) {
            $property = Property::create([
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
                'image' => 'default_image.jpg',
            ]);
        };

		for ($j = 0; $j < rand(1, 5); $j++) {
			$property->images()->create([
				'image_path' => 'additional_image_' . $j . '.jpg',
			]);
		}
		
    }
}
