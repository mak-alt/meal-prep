<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\WeeklyMenuRequest;
use App\Models\Meal;
use App\Models\WeeklyMenu;
use Illuminate\Http\Request;

class WeeklyMenuController extends Controller
{
    public function create(){
        $other = Meal::get();
        $all_meals = Meal::where('type', 'entry')->get();
        $all_sides = Meal::where('type', 'side')->get();
        return view('backend.weekly-menu.create')->with([
            'all_meals' => $all_meals,
            'all_sides' => $all_sides,
            'other' => $other,
        ]);
    }

    public function store(WeeklyMenuRequest $request){
        try {
            $data = $request->except(['_token']);
            if ($request->has('status')) {
                $data['status'] = $request->has('status');
                WeeklyMenu::where('status', true)
                    ->get()
                    ->map(function ($menu) {
                        $menu->update(['status' => false]);
                    });
            }
            WeeklyMenu::create($data);
            return redirect()->back()->with('success', 'Weekly menu was successfully created.');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Weekly menu creation failed.');
        }
    }

    public function edit(WeeklyMenu $weeklyMenu){
        $other = Meal::get();
        $all_meals = Meal::where('type', 'entry')->get();
        $all_sides = Meal::where('type', 'side')->get();
        return view('backend.weekly-menu.edit')->with([
            'weeklyMenu' => $weeklyMenu,
            'all_meals' => $all_meals,
            'all_sides' => $all_sides,
            'other' => $other,
        ]);
    }

    public function update(WeeklyMenu $weeklyMenu, WeeklyMenuRequest $request){
        try {
            $data = $request->except(['_token']);
            if ($request->has('status')) {
                WeeklyMenu::where('status', true)
                    ->get()
                    ->map(function ($menu) {
                        $menu->update(['status' => false]);
                    });
            }
            $data['status'] = $request->has('status');
            $weeklyMenu->update($data);
            return redirect()->back()->with('success', 'Weekly menu was successfully created.');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Weekly menu creation failed.');
        }
    }

    public function destroy(WeeklyMenu $weeklyMenu, Request $request){
        try {
            if ($request->ajax()) {
                $weeklyMenu->delete();

                return response()->json($this->formatResponse('success', 'Menu has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Menu deletion failed.'), 400);
        }
    }
}
