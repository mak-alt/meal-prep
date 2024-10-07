<?php

namespace Database\Seeders;

use App\Models\MenuPlanPrice;
use Illuminate\Database\Seeder;

class MenuPlanPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices = [
            [
                'count' => 5,
                'price' => 76.00
            ],
            [
                'count' => 6,
                'price' => 89.00
            ],
            [
                'count' => 7,
                'price' => 102.00
            ],
            [
                'count' => 8,
                'price' => 115.00
            ],
            [
                'count' => 9,
                'price' => 128.00
            ],
            [
                'count' => 10,
                'price' => 135.00
            ],
            [
                'count' => 12,
                'price' => 159.00
            ],
            [
                'count' => 14,
                'price' => 188.00
            ],
            [
                'count' => 20,
                'price' => 266.00
            ],
            [
                'count' => 24,
                'price' => 282.00
            ],
        ];

        foreach ($prices as $price){
            MenuPlanPrice::create([
                'count' => $price['count'],
                'price' => $price['price']
            ]);
        }
    }
}
