<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             UsersTableSeeder::class,
             TagsTableSeeder::class,
             CategoriesTableSeeder::class,
             IngredientsTableSeeder::class,
             MealsTableSeeder::class,
             MenusTableSeeder::class,
             AddonsTableSeeder::class,
             PagesTableSeeder::class,
             SettingsTableSeeder::class,
             AdminMenusTableSeeder::class,
             MenuPlanPricesTableSeeder::class,
             DeliveryTimeSeeder::class,
         ]);
    }
}
