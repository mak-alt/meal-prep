<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SessionStorageHandlers\ShoppingCartSessionStorageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * @param string $status
     * @return \Illuminate\Contracts\View\View
     */
    public function index(string $status): View
    {
        $ordersQuery = auth()->user()->orders();
        $ordersExist = $ordersQuery->exists();
        $orders      = $ordersQuery
            ->where('status', $status)
            ->with(['orderItems.orderItemables.orderItemable', 'orderItems.orderItemables.children.orderItemable'])
            ->latest()
            ->get();

        return \view('frontend.orders.index', compact('status', 'orders', 'ordersExist'));
    }

    /**
     * @param \App\Models\Order $order
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Order $order): View
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        $order->load(['orderItems.orderItemables.orderItemable', 'orderItems.orderItemables.children.orderItemable']);

        return \view('frontend.orders.show', compact('order'));
    }

    /**
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function downloadReceipt(Order $order): Response
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        $order->load(['orderItems.orderItemables.orderItemable', 'orderItems.orderItemables.children.orderItemable']);

        $pdf = app()->make('dompdf.wrapper')->loadView('frontend.orders.partials.receipt', compact('order'));

        return $pdf->download("order-#{$order->id}-receipt-{$order->created_at->format('m-d-Y')}.pdf");
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function repeat(Request $request, Order $order): JsonResponse
    {
        if ($request->ajax()) {
            try {
                ShoppingCartSessionStorageService::repeatOrder($order);

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Order has been successfully added to your shopping cart',
                        ['redirect' => route('frontend.shopping-cart.index')]
                    )
                );
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Repeating order failed.'), 400);
            }
        }
    }
}
