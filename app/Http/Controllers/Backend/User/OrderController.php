<?php

namespace App\Http\Controllers\Backend\User;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $orders = Order::with('user');
        if ($request->has('orderDate')){
            $dates = explode(':', $request->orderDate);
            $orders->whereDate('created_at','>=', $dates[0],)
                ->whereDate('created_at','<=', $dates[1]);
        }
        if ($request->has('deliveryDate')){
            $dates = explode(':', $request->deliveryDate);
            $orders->whereDate('delivery_date','>=', $dates[0],)
                ->whereDate('delivery_date','<=', $dates[1]);
        }
        if ($request->has('search')){
            $orders->where('id', $request->search)
                ->orWhereHas('user', function($q) use ($request){
                    $q->where('first_name','like', '%'.$request->search.'%')
                      ->orWhere('last_name','like', '%'.$request->search.'%');
                });
        }
        $orders = $orders->latest()->paginate(15);

        return \view('backend.orders.index', compact('orders'));
    }

    /**
     * @param \App\Models\Order $order
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Order $order): View
    {
        $order->load([
            'user',
            'paymentHistory',
            'orderItems.orderItemables.orderItemable',
            'orderItems.orderItemables.children.orderItemable',
        ]);

        $coupons = $order->user->usedCoupons->filter(function ($value, $key) use ($order) {
            return ($value->created_at > Carbon::parse($order->created_at)->addMinutes(-20)) && $value->created_at < Carbon::parse($order->created_at)->addMinutes(20);
        });
        if ($coupons->isNotEmpty()) {
            $couponId = $coupons->first()->coupon_id;
            $coupon = Coupon::find($couponId);
            if ($coupon !== null) {
                $couponCode = $coupon->coupon_code;
            } else {
                $couponCode = '';
            }
        } else {
            $couponCode = '';
        }
//        $gifts = $order->gifts()
//            ->whereNotNull('redeemed_at')
//            ->whereNull('used_at')
//            ->get();
//dd($gifts);
        $entry = [];
        $sides = [];
        foreach ($order->orderItems as $orderItem){
            foreach ($orderItem->orderItemables->whereNull('parent_id') as $orderItemable){
                if  (array_key_exists($orderItemable->order_itemable_id, $entry)){
                    $entry[$orderItemable->order_itemable_id]['count']++;
                }
                else{
                    $entry[$orderItemable->order_itemable_id] = [
                        'name' => $orderItemable->orderItemable->name,
                        'count' => 1,
                    ];
                }
                foreach ($orderItemable->children as $orderItemableChild){
                    if  (array_key_exists($orderItemableChild->order_itemable_id, $sides)){
                        $sides[$orderItemableChild->order_itemable_id]['count']++;
                    }
                    else{
                        $sides[$orderItemableChild->order_itemable_id] = [
                            'name' => $orderItemableChild->orderItemable->name,
                            'count' => 1,
                        ];
                    }
                }
            }
        }

        return \view('backend.orders.show', compact('order', 'entry', 'sides', 'couponCode'));
    }

    /**
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function showReceipt(Order $order): Response
    {
        $order->load(['orderItems.orderItemables.orderItemable', 'orderItems.orderItemables.children.orderItemable']);

        $pdf = app()->make('dompdf.wrapper')->loadView('frontend.orders.partials.receipt', compact('order'));

        return $pdf->stream();
    }

    public function exportToExcel(Request $request)
    {
        if ($request->ajax()){
            $orders = Order::with('user');
            if ($request->has('deliveryDate')){
                $dates = explode(':', $request->deliveryDate);
                $from = Carbon::parse($dates[0])->format('Y-m-d');
                $to = Carbon::parse($dates[1])->format('Y-m-d');
                if ($request->has('type')){
                    if ($request->type === 'pickup'){
                        if ($from === $to){
                            $orders->where('pickup_date','like', '%'.$from.'%');
                        } else $orders->whereBetween('pickup_date', [$from, $to]);
                    }
                    elseif($request->type === 'delivery'){
                        if ($from === $to){
                            $orders->where('delivery_date','like', '%'.$from.'%');
                        } else $orders->whereBetween('delivery_date', [$from, $to]);
                    }
                }
                else{
                    if ($from === $to){
                        $orders->where('delivery_date','like', '%'.$from.'%')
                            ->orWhere('pickup_date','like', '%'.$from.'%');
                    } else $orders->whereBetween('delivery_date', [$from, $to])
                        ->orWhereBetween('pickup_date', [$from, $to]);
                }
            }
            if ($request->has('date')){
                if ($request->date === 'today'){
                    $orders->where('delivery_date', 'like', '%'.today()->format('Y-m-d').'%')
                        ->orWhere('pickup_date', 'like', '%'.today()->format('Y-m-d').'%');
                }
                elseif (is_numeric($request->date)){
                    $to = today()->format('Y-m-d');
                    $from = today()->subDays($request->date)->format('Y-m-d');
                    if ($request->has('type')){
                        if ($request->type === 'pickup'){
                            $orders->whereBetween('pickup_date', [$from, $to]);
                        }
                        elseif($request->type === 'delivery'){
                            $orders->whereBetween('delivery_date', [$from, $to]);
                        }
                    }
                    else{
                        $orders->whereBetween('delivery_date', [$from, $to])
                            ->orWhereBetween('pickup_date', [$from, $to]);
                    }
                }
            }
            if ($request->has('type')){
                if ($request->type === 'pickup'){
                    $orders->whereNull('delivery_date')->whereNotNull('pickup_date');
                }
                elseif($request->type === 'delivery'){

                    $orders->whereNull('pickup_date')->whereNotNull('delivery_date');
                }
            }


            if ($orders->count() === 0){
                return \response()->json([
                    'success' => false,
                    'message' => 'There is no orders with these filters.'
                ]);
            }
            else{
                return \response()->json([
                    'success' => true,
                ]);
            }
        }

        $export = new OrdersExport($request);
        $exportedFileName = 'orders' . date('m-d-Y');

        $exportedFileName .= '.csv';

        return Excel::download($export, $exportedFileName);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function exportToPdf(Request $request){
        set_time_limit(500);
        try {
            $orders = Order::with('user');
            if ($request->has('deliveryDate')){
                $dates = explode(':', $request->deliveryDate);
                $from = Carbon::parse($dates[0])->format('Y-m-d');
                $to = Carbon::parse($dates[1])->format('Y-m-d');
                if ($request->has('type')){
                    if ($request->type === 'pickup'){
                        if ($from === $to){
                            $orders->where('pickup_date','like', '%'.$from.'%');
                        } else $orders->whereBetween('pickup_date', [$from, $to]);
                    }
                    elseif($request->type === 'delivery'){
                        if ($from === $to){
                            $orders->where('delivery_date','like', '%'.$from.'%');
                        } else $orders->whereBetween('delivery_date', [$from, $to]);
                    }
                }
                else{
                    if ($from === $to){
                        $orders->where('delivery_date','like', '%'.$from.'%')
                            ->orWhere('pickup_date','like', '%'.$from.'%');
                    } else $orders->whereBetween('delivery_date', [$from, $to])
                        ->orWhereBetween('pickup_date', [$from, $to]);
                }
            }
            if ($request->has('date')){
                if ($request->date === 'today'){
                    $orders->where('delivery_date', 'like', '%'.today()->format('Y-m-d').'%')
                        ->orWhere('pickup_date', 'like', '%'.today()->format('Y-m-d').'%');
                }
                elseif (is_numeric($request->date)){
                    $to = today()->format('Y-m-d');
                    $from = today()->subDays($request->date)->format('Y-m-d');
                    if ($request->has('type')){
                        if ($request->type === 'pickup'){
                            $orders->whereBetween('pickup_date', [$from, $to]);
                        }
                        elseif($request->type === 'delivery'){
                            $orders->whereBetween('delivery_date', [$from, $to]);
                        }
                    }
                    else{
                        $orders->whereBetween('delivery_date', [$from, $to])
                            ->orWhereBetween('pickup_date', [$from, $to]);
                    }
                }
            }
            if ($request->has('type')){
                if ($request->type === 'pickup'){
                    $orders->whereNull('delivery_date')->whereNotNull('pickup_date');
                }
                elseif($request->type === 'delivery'){
                    $orders->whereNull('pickup_date')->whereNotNull('delivery_date');
                }
            }
            $orders = $orders->latest()->get();
            if ($request->ajax()){
                if (count($orders) === 0){
                    return \response()->json([
                        'success' => false,
                        'message' => 'There is no orders with these filters.'
                    ]);
                }
                else{
                    return \response()->json([
                        'success' => true,
                    ]);
                }
            }
            $entries = [];
            $sides = [];
            $entryCount = [];
            $sidesCount = [];

            foreach ($orders as $order){
                foreach ($order->orderItems as $orderItem){
                    foreach ($orderItem->orderItemables->whereNull('parent_id') as $orderItemable){
                        if  (array_key_exists($orderItemable->order_itemable_id, $entries[$order->id] ?? [])){
                            $entries[$order->id][$orderItemable->order_itemable_id]['count']++;
                        }
                        else{
                            $entries[$order->id][$orderItemable->order_itemable_id] = [
                                'name' => $orderItemable->orderItemable->name,
                                'count' => 1,
                            ];
                        }
                        foreach ($orderItemable->children as $orderItemableChild){
                            if  (array_key_exists($orderItemableChild->order_itemable_id, $sides[$order->id] ?? [])){
                                $sides[$order->id][$orderItemableChild->order_itemable_id]['count']++;
                            }
                            else{
                                $sides[$order->id][$orderItemableChild->order_itemable_id] = [
                                    'name' => $orderItemableChild->orderItemable->name,
                                    'count' => 1,
                                ];
                            }
                        }
                    }
                }
                foreach ($order->orderItems as $orderItem){
                    foreach ($orderItem->orderItemables->whereNull('parent_id') as $orderItemable){
                        if  (array_key_exists($orderItemable->order_itemable_id, $entryCount)){
                            $entryCount[$orderItemable->order_itemable_id]['count']++;
                        }
                        else{
                            $entryCount[$orderItemable->order_itemable_id] = [
                                'name' => $orderItemable->orderItemable->name,
                                'count' => 1,
                            ];
                        }
                        foreach ($orderItemable->children as $orderItemableChild){
                            if  (array_key_exists($orderItemableChild->order_itemable_id, $sidesCount)){
                                $sidesCount[$orderItemableChild->order_itemable_id]['count']++;
                            }
                            else{
                                $sidesCount[$orderItemableChild->order_itemable_id] = [
                                    'name' => $orderItemableChild->orderItemable->name,
                                    'count' => 1,
                                ];
                            }
                        }
                    }
                }

                $coupons = $order->user->usedCoupons->filter(function ($value, $key) use ($order) {
                    return ($value->created_at > Carbon::parse($order->created_at)->addMinutes(-20)) && $value->created_at < Carbon::parse($order->created_at)->addMinutes(20);
                });
                if ($coupons->isNotEmpty()) {
                    $couponId = $coupons->first()->coupon_id;
                    $coupon = Coupon::find($couponId);
                    if ($coupon !== null) {
                        $order->couponCode = $coupon->coupon_code;
                    } else {
                        $order->couponCode = '';
                    }
                } else {
                    $order->couponCode = '';
                }
            }

            $exportedFileName = 'orders' . date('m-d-Y');
            view()->share([
                'orders'=> $orders,
                'entries' => $entries,
                'sides' => $sides,
                'entryCount' => $entryCount,
                'sidesCount' => $sidesCount,
            ]);
            $pdf = app()->make('dompdf.wrapper')->loadView('backend.exports.orders',[
                'orders'=> $orders,
                'entries' => $entries,
                'sides' => $sides,
                'entryCount' => $entryCount,
                'sidesCount' => $sidesCount,
            ])->setPaper('a4','portrait');
            $exportedFileName .= '.pdf';

            return $pdf->download($exportedFileName);
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }

    public function printSingleOrder(Request $request, Order $order){
        $entry = [];
        $sides = [];

        foreach ($order->orderItems as $orderItem){
            foreach ($orderItem->orderItemables->whereNull('parent_id') as $orderItemable){
                if  (array_key_exists($orderItemable->order_itemable_id, $entry)){
                    $entry[$orderItemable->order_itemable_id]['count']++;
                }
                else{
                    $entry[$orderItemable->order_itemable_id] = [
                        'name' => $orderItemable->orderItemable->name,
                        'count' => 1,
                    ];
                }
                foreach ($orderItemable->children as $orderItemableChild){
                    if  (array_key_exists($orderItemableChild->order_itemable_id, $sides)){
                        $sides[$orderItemableChild->order_itemable_id]['count']++;
                    }
                    else{
                        $sides[$orderItemableChild->order_itemable_id] = [
                            'name' => $orderItemableChild->orderItemable->name,
                            'count' => 1,
                        ];
                    }
                }
            }
        }

        $coupons = $order->user->usedCoupons->filter(function ($value, $key) use ($order) {
            return ($value->created_at > Carbon::parse($order->created_at)->addMinutes(-20)) && $value->created_at < Carbon::parse($order->created_at)->addMinutes(20);
        });
        if ($coupons->isNotEmpty()) {
            $couponId = $coupons->first()->coupon_id;
            $coupon = Coupon::find($couponId);
            if ($coupon !== null) {
                $couponCode = $coupon->coupon_code;
            } else {
                $couponCode = '';
            }
        } else {
            $couponCode = '';
        }

        $exportedFileName = 'order-' . $order->id;
        view()->share([
            'order'=> $order,
            'entry' => $entry,
            'sides' => $sides,
            'couponCode' => $couponCode,
        ]);
        $pdf = app()->make('dompdf.wrapper')->loadView('backend.exports.order',[
            'order'=> $order,
            'entry' => $entry,
            'sides' => $sides,
        ])->setPaper('a4','portrait');
        $exportedFileName .= '.pdf';

        return $pdf->download($exportedFileName);
    }

    public function destroy(Order $order, Request $request){
        if ($request->ajax()){
            try {
                $order->delete();
                return response()->json($this->formatResponse('success', 'Order has been successfully deleted.'));
            }
            catch (\Exception $exception){
                return response()->json($this->formatResponse('error', 'Order deletion failed.'), 400);
            }
        }
    }

    public function toggleStatus(Order $order)
    {
        try {

            if ($order->status === 'upcoming'){
                $order->update([
                    'status' => 'completed',
                ]);
            }
            else{
                $order->update([
                    'status' => 'upcoming',
                ]);
            }

            return redirect()->route('backend.orders.show', $order->id)->with('success', "Order status was changed to $order->status");
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', 'Order status update failed.');
        }
    }

    public function printOptionsPage()
    {
        return \view('backend.orders.print-options');
    }
}
