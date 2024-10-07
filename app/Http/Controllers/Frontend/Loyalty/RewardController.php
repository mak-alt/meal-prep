<?php

namespace App\Http\Controllers\Frontend\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class RewardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user) {
            $orders     = $user->orders()->latest()->get();
            $userReward = $user->userReward;
        } else {
            $orders     = collect();
            $userReward = null;
        }

        return \view('frontend.rewards.index', compact('orders', 'userReward'));
    }
}
