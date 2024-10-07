<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * @var array|\string[][]
     */
    private array $categoriesData = [
        [
            'key'         => 'healthy_mix',
            'name'        => 'Healthy mix',
            'description' => 'This diet is a combination of our menu offerings. Can contain cheese, rice, grains, nuts, meats & veggies.',
        ],
        [
            'key'         => 'paleo',
            'name'        => 'Paleo',
            'description' => 'This diet omits dairy, sugar, butter, rice, grains & white potatoes, legumes, soy. Can contain meats and nuts.',
        ],
        [
            'key'         => 'keto',
            'name'        => 'Keto',
            'description' => 'This is a 30-day reset diet that omits legumes, dairy & sweeteners. Can contain meats, vegetables, fruits & nuts.',
        ],
        [
            'key'         => 'w30',
            'name'        => 'W30',
            'description' => 'This is a low carb diet that omits rice, grains, legumes, potatoes, fruits. Contains meat, cheese & green veggies.',
        ],
        [
            'key'         => 'vegan',
            'name'        => 'Vegan',
            'description' => 'This diet omits all animal products of any kind.',
        ],
        [
            'key'         => 'custom_menu',
            'name'        => 'Custom menu',
            'description' => 'This is a special category for custom menu addons.',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categoriesData as $categoryData) {
            Category::updateOrCreate(['key' => $categoryData['key']], $categoryData);
        }
    }
}
