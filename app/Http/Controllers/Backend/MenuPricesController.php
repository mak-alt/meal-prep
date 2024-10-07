<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PricePlanRequest;
use App\Models\MenuPlanPrice;
use App\Models\Setting;
use Illuminate\Http\Request;

class MenuPricesController extends Controller
{
    public function index(){
        $avg_price = Setting::key('avg_price')->first()->data ?? 0;
        $prices = MenuPlanPrice::get();

        return view('backend.menus.prices')->with([
            'prices' => $prices,
            'avg_price' => $avg_price,
        ]);
    }

    public function update(PricePlanRequest $request){
        if ($request->has('avg_price')){
            Setting::updateOrCreateSettings([
                'avg_price' => $request->avg_price,
            ]);
        }
        MenuPlanPrice::truncate();

        foreach ($request->plan as $plan){
            MenuPlanPrice::create(
                [
                    'count' => $plan['count'],
                    'price' => $plan['price'],
                ]);
        }
        return redirect()->back()->with('success', 'Menu prices were successfully updated.');
    }
}
