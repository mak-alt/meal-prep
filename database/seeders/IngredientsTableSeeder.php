<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Faker\Factory;
use Faker\Generator;
use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Database\Seeder;

class IngredientsTableSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    protected Generator $faker;

    /**
     * IngredientsTableSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new Restaurant($this->faker));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        for ($i = 0; $i <= 100; $i++) {
            $fakerMethods      = ['beverageName', 'dairyName', 'vegetableName', 'fruitName', 'meatName', 'sauceName'];
            $fakerRandomMethod = $fakerMethods[array_rand($fakerMethods)];

            $ingredientName = $this->faker->$fakerRandomMethod;

            try {
                Ingredient::updateOrCreate(
                    ['name' => $ingredientName],
                    ['name' => $ingredientName, 'description' => $ingredientName . ' description']
                );
            } catch (\Throwable $exception) {}
        }
    }
}
