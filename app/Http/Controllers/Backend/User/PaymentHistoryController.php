<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $payments = PaymentHistory::with('user')->latest()->paginate(15);

        return \view('backend.users.payment-history.index', compact('payments'));
    }
}
