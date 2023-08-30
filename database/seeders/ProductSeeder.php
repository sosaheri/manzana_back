<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $faker->addProvider(new \FakerRestaurant\Provider\es_PE\Restaurant($faker));

        foreach (range(1, 20) as $index) {
            Product::create([
                'name' => $faker->foodName(),
                'description' => $faker->paragraph,
                'url_img' => $faker->imageUrl(),
            ]);
        }
    }
}
