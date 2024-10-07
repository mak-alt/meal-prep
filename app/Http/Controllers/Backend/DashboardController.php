<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $countVisitors   = Visitor::where('date', today())->count();
        $users           = User::count();
        $upcomingOrders  = Order::where('status', 'upcoming')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $latestOrders    = Order::latest()->take(8)->get();
        $weeklyMenu      = Menu::where('status', true)->get();

        return view('backend.dashboard.index', compact(
            'countVisitors',
            'users',
            'upcomingOrders',
            'completedOrders',
            'weeklyMenu',
            'latestOrders'
        ));
    }

    /**
     * @throws \Exception
     */
    public function makePayment(Request $request){
        $card = str_replace(' ', '', $request->card_number);
        $csc = $request->csc;
        [$month, $year] = explode('/',$request->expiration);
        $body = [
            'merchant_ref'          => 'AMP',
            'transaction_type'      => 'purchase',
            'method'                => 'credit_card',
            'amount'                => '10',
            'partial_redemption'    => 'false',
            'currency_code'         => 'USD',
            'credit_card' => [
                'type' => 'visa',
                'cardholder_name' => 'Mr. Anderson',
                'card_number' => $card,
                'exp_date' => $month.$year,
                'cvv' => $csc,
            ]
        ];
        $nonce = random_int(0,PHP_INT_MAX);
        $timestamp = (int)now()->getPreciseTimestamp(3);
        $token = env('MERCHANT_TOKEN');
        $msg = env('PAYMENT_API_KEY').$nonce.$timestamp.$token.json_encode($body);
        $hash = hash_hmac('sha256',$msg, env('PAYMENT_API_SECRET'));
        $response = Http::withHeaders([
            'apikey' => env('PAYMENT_API_KEY'),
            'token' => $token,
            'Content-type' => 'application/json',
            'Authorization' => base64_encode($hash),
            'nonce' => $nonce,
            'timestamp' => $timestamp,
        ])->post(env('API_URL'), $body);
        dd($response->json());
    }
}
