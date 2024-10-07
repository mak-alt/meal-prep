<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\MenuPlanPrice;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $addToCartProcess = auth()->check() && session()->has('add-to-cart');
        $minMealPrice     = Meal::where('type', 'entry')->min('price');
        $main_photo       = Setting::key('thumb')->first()->data ?? 'assets/frontend/img/home-section1-img.jpg';
        $sub_photo       = Setting::key('thumb2')->first()->data ?? 'assets/frontend/img/subscribe.png';

        return \view('frontend.landing.index', compact(
    'addToCartProcess',
    'minMealPrice',
            'main_photo',
            'sub_photo'
        ));
    }

    public function getMenuPrice(Request $request) {
        try {
            $price = MenuPlanPrice::where('count',$request->amountMeal)->first()->price;
            return response()->json([
                'price' => $price,
            ]);
        }catch (\Exception $exception){
            $avg_price = Setting::key('avg_price')->first()->data ?? 0;
            return response()->json([
                'price' => $avg_price * $request->amountMeal,
            ]);
        }
    }


    public function stripe_payment_process($id){

        $sessionId = $id;
        return \view('dummy.index', compact(
            'sessionId'
                ));
    }
    
}
