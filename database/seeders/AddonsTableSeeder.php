<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Category;
use App\Models\Meal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class AddonsTableSeeder extends Seeder
{
    /**
     * @var array|array[]
     */
    private array $addonsData = [
        ['name' => 'Breakfast', 'required_minimum_meals_amount' => 2],
        ['name' => 'Vegan bowl', 'required_minimum_meals_amount' => 4],
        ['name' => 'Snacks', 'required_minimum_meals_amount' => 4],
    ];

    /**
     * @var \Illuminate\Support\Collection
     */
    private Collection $categories;

    /**
     * @var \Illuminate\Support\Collection
     */
    private Collection $meals;

    /**
     * AddonsTableSeeder constructor.
     */
    public function __construct()
    {
        $this->categories = Category::all(['id', 'key', 'name', 'description']);
        $this->meals      = Meal::where('type', 'addon')->get(['id', 'price', 'points']);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        foreach ($this->addonsData as $key =>$addonData) {
            $addon = Addon::updateOrCreate(['name' => $addonData['name']], $addonData);

            $addonMealsData = [];
            foreach ($this->meals->random(random_int(1, 5)) as $meal) {
                $price = 10;
                $addonMealsData[$meal->id] = ['price' => $price, 'points' => $price * 10];
            }

            $addon->meals()->sync($addonMealsData);
            if ($key === 0){
                $addon->categories()->sync($this->categories->where('key', 'custom_menu')->first()->id);
            } else $addon->categories()->sync($this->categories->random()->first()->id);
        }
    }
}
