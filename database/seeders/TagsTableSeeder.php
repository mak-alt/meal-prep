<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * @var array|\string[][]
     */
    private array $tagsData = [
        ['name' => 'Paleo'],
        ['name' => 'Pescatarian'],
        ['name' => 'Vegan'],
        ['name' => 'Vegetarian'],
        ['name' => 'High-Protein'],
        ['name' => 'Keto'],
        ['name' => 'Low-Calorie'],
        ['name' => 'Low-Carb'],
        ['name' => 'Zone'],
        ['name' => 'Halal'],
        ['name' => 'Dairy-Free'],
        ['name' => 'Gluten-Free'],
        ['name' => 'Meat'],
        ['name' => 'Nut-Free'],
        ['name' => 'W30'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->tagsData as $tagData) {
            Tag::updateOrCreate(['name' => $tagData['name']], $tagData);
        }
    }
}
