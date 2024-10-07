<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Tag;
use Faker\Factory;
use Faker\Generator;
use FakerRestaurant\Provider\en_US\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class MealsTableSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    protected Generator $faker;

    /**
     * @var \Illuminate\Support\Collection|\App\Models\Category[]|\Illuminate\Database\Eloquent\Collection
     */
    protected Collection $categories;

    /**
     * @var \Illuminate\Support\Collection|\App\Models\Ingredient[]|\Illuminate\Database\Eloquent\Collection
     */
    protected Collection $ingredients;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $tags;

    protected $mealNames;
    protected $sideNames;
    protected $addonNames;

    /**
     * IngredientsTableSeeder constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new Restaurant($this->faker));

        $this->categories  = Category::where('key', '!=', 'custom_menu')->get(['id']);
        $this->ingredients = Ingredient::all(['id']);
        $this->tags        = Tag::all(['name']);

        $this->mealNames = [
            'Vegan Bowl',
            'Beef Stroganoff',
            'Reuben',
            'Sandwich',
            'Waldorf Salad',
            'French Fries',
            'Caesar Salad',
            'Chicken a la King',
            'Lobster Newburgh',
            'Salisbury Steak',
            'Baked Alaska',
            'Eggs Benedict',
            'Carpaccio',
            'California Roll',
            'Peach Melba',
            'Fettuccine Alfredo',
            'Beef Stroganoff 2',
            'Reuben 2',
            'Sandwich 2',
            'Waldorf Salad 2',
            'French Fries 2',
            'Caesar Salad 2',
            'Chicken a la King 2',
            'Lobster Newburgh 2',
            'Salisbury Steak 2',
        ];

        $this->sideNames = [
            'Side Beef Stroganoff',
            'Side Reuben',
            'Side Sandwich',
            'Side Waldorf Salad',
            'Side French Fries',
            'Side Caesar Salad',
            'Side Chicken a la King',
            'Side Lobster Newburgh',
            'Side Salisbury Steak',
            'Side Baked Alaska',
            'Side Eggs Benedict',
            'Side Carpaccio',
            'Side California Roll',
            'Side Peach Melba',
            'Side Fettuccine Alfredo',
        ];

        $this->addonNames = [
            'Addon Beef Stroganoff',
            'Addon Reuben',
            'Addon Sandwich',
            'Addon Waldorf Salad',
            'Addon French Fries',
            'Addon Caesar Salad',
            'Addon Chicken a la King',
            'Addon Lobster Newburgh',
            'Addon Salisbury Steak',
            'Addon Baked Alaska',
            'Addon Eggs Benedict',
            'Addon Carpaccio',
            'Addon California Roll',
            'Addon Peach Melba',
            'Addon Fettuccine Alfredo',
        ];

    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        for ($i = 1; $i <= 25; $i++) {

            $price = ($i % 5)
                ? 0
                : random_int(1, 5);

            $meal = Meal::create(
                [
                    'name'        => $this->mealNames[$i-1],
                    'price'       => $price,
                    'points'      => $price*10,
                    'calories'    => random_int(0, 300),
                    'fats'        => random_int(0, 300),
                    'carbs'       => random_int(0, 300),
                    'proteins'    => random_int(0, 300),
                    'type'        => 'entry',
                    'description' => $this->mealNames[$i-1] ." description",
                    'tags'        => $this->tags->random(1)->pluck('name')->toArray(),
                    'order_id'    => $i,
                    'side_count' => $this->mealNames[$i-1] === 'Vegan Bowl' ? 4 : 2,
                ]
            );
            if ($this->mealNames[$i-1] === 'Vegan Bowl'){
                $meal->categories()->sync(Category::where('key', 'vegan')->first(['id']));
            } else {
                if ($i <= 5){
                    $meal->categories()->sync(Category::where('key', 'vegan')->first(['id']));
                }elseif ($i > 5 && $i <=10){
                    $meal->categories()->sync(Category::where('key', 'healthy_mix')->first(['id']));
                }elseif($i > 10 && $i <= 15){
                    $meal->categories()->sync(Category::where('key', 'paleo')->first(['id']));
                }elseif($i > 15 && $i <= 20){
                    $meal->categories()->sync(Category::where('key', 'keto')->first(['id']));
                }elseif($i > 20 && $i <= 25){
                    $meal->categories()->sync(Category::where('key', 'w30')->first(['id']));
                }
            }

            $meal->ingredients()->sync($this->ingredients->random(random_int(2, 5)));
        }

        for ($i = 1; $i <= 15; $i++) {
            $side = Meal::create(
                [
                    'name'        => $this->sideNames[$i-1],
                    'price'       => 0,
                    'points'      => 0,
                    'calories'    => random_int(0, 300),
                    'fats'        => random_int(0, 300),
                    'carbs'       => random_int(0, 300),
                    'proteins'    => random_int(0, 300),
                    'type'        => 'side',
                    'description' => $this->sideNames[$i-1]." description",
                    'tags'        => $this->tags->random(1)->pluck('name')->toArray(),
                    'order_id'    => $i,
                ]
            );

            if ($i <= 4){
                $side->categories()->sync(Category::where('key', 'vegan')->first(['id']));
            }elseif ($i > 4 && $i <=6){
                $side->categories()->sync(Category::where('key', 'healthy_mix')->first(['id']));
            }elseif($i > 6 && $i <= 8){
                $side->categories()->sync(Category::where('key', 'paleo')->first(['id']));
            }elseif($i > 8 && $i <= 10){
                $side->categories()->sync(Category::where('key', 'keto')->first(['id']));
            }elseif($i > 10 && $i <= 12){
                $side->categories()->sync(Category::where('key', 'w30')->first(['id']));
            }else {
                $side->categories()->sync($this->categories->random());
            }
            $side->ingredients()->sync($this->ingredients->random(random_int(2, 5)));
        }

        for ($i = 1; $i <= 15; $i++) {
            $addon = Meal::create(
                [
                    'name'        => $this->addonNames[$i-1],
                    'price'       => 10,
                    'points'      => 100,
                    'calories'    => random_int(0, 300),
                    'fats'        => random_int(0, 300),
                    'carbs'       => random_int(0, 300),
                    'proteins'    => random_int(0, 300),
                    'type'        => 'addon',
                    'description' => $this->addonNames[$i-1]." description",
                    'tags'        => $this->tags->random(1)->pluck('name')->toArray(),
                    'order_id'    => $i,
                ]
            );
            $addon->categories()->sync($this->categories->random());
            $addon->ingredients()->sync($this->ingredients->random(random_int(2, 5)));
        }


        $meals = Meal::where('type', 'entry')->get();

        foreach ($meals as $meal) {
            $mealSidesData = [];
            $mealCat = $meal->categories()->first();
            if ($meal->name === 'Vegan Bowl'){
                $vegan = Category::where('key', 'vegan')->first()->id;
                $mealSides     = Meal::where('type', 'side')->whereHas('categories', function ($query) use ($vegan){
                    return $query->where('category_id', $vegan);
                })->get()->random(4);
            } else $mealSides = Meal::where('type', 'side')->whereHas('categories', function ($query) use ($mealCat){
                return $query->where('category_id', $mealCat->id);
            })->get()->random(random_int(2,$mealCat->meals->where('type', 'side')->count()));
            if ($mealSides->isNotEmpty()) {
                foreach ($mealSides as $side) {
                    $mealSidesData[$side->id] = ['price' => $side->price, 'points' => $side->points];
                }
                $meal->sides()->sync($mealSidesData);
            }
        }

    }
}
