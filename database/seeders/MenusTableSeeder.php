<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Meal;
use App\Models\MealMenuSide;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class MenusTableSeeder extends Seeder
{
    /**
     * @var \Illuminate\Support\Collection|\App\Models\Category[]|\Illuminate\Database\Eloquent\Collection
     */
    protected Collection $categories;

    /**
     * @var \Illuminate\Support\Collection|\App\Models\Ingredient[]|\Illuminate\Database\Eloquent\Collection
     */
    protected Collection $meals;

    /**
     * MealsTableSeeder constructor.
     */
    public function __construct()
    {
        $this->categories = Category::where('key', '!=', 'custom_menu')->get(['id']);
        //$this->meals      = Meal::where('type', 'entry')->get(['id']);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $cat = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>1,7=>2,8=>3,9=>4,10=>5];
        MealMenuSide::truncate();

        for ($i = 1; $i <= 10; $i++) {
            $price = random_int(60, 99);
            $cat_id = $cat[$i];
            $data = [
                'name'        => "Menu $i",
                'category_id' => $cat_id,
                'price'       => $price,
                'points'      => $price*10,
                'calories'    => random_int(0, 300),
                'fats'        => random_int(0, 300),
                'carbs'       => random_int(0, 300),
                'proteins'    => random_int(0, 300),
                'description' => "Menu $i",
            ];
            if(($i == 2) || ($i == 7)) {
                $data['weekly_menu'] = 1;
            }

            $menu = Menu::updateOrCreate(
                ['name' => "Menu $i"], $data
            );

            $menuMeals = Meal::where('type', 'entry')->whereHas('categories', function ($query) use ($cat_id){
                return $query->where('category_id',$cat_id);
            })->get(['id']);
           /* })->get(['id'])->random(random_int(1, Category::find($cat_id)->meals()->where('type', 'entry')->count()));*/
            $menu->meals()->sync($menuMeals);

            $menu->meals()->get()->map(function ($meal) use($menu) {
                foreach ($meal->sides()->inRandomOrder()->limit(2)->get() as $side) {
                    MealMenuSide::create([
                        'menu_id' => $menu->id,
                        'meal_id' => $meal->id,
                        'side_id' => $side->id,
                    ]);
                }
            });
        }


        foreach (Menu::groupBy('category_id')->latest()->get() as $menu) {
            $menu->update(['status' => true]);
        }
    }
}
