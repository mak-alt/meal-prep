<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize,WithStyles,WithColumnFormatting
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $request = $this->request;
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

        return $orders->latest()->get();
    }

    public function map($order): array
    {
        $user = User::find($order->user_id);
        $mealNames = [];
        foreach ($order->orderItems as $orderItem){
            $mealNames[] = $orderItem->portion_size != null ? $orderItem->name . " Size: $orderItem->portion_size oz" : $orderItem->name;
        }
        $mealPrices = $order->orderItems()->pluck('total_price')->toArray();
        if($order->orderItems()->count() > 1){
            for($i = 0; $i <= $order->orderItems()->count() - 1; $i++){
                if ($i === 0){
                    $returnArray = [
                        [
                            $order->created_at->format('m/d/Y'),
                            $order->id,
                            $user->first_name,
                            $user->last_name,
                            $user->email,
                            $mealNames[$i],
                            $mealPrices[$i],
                            $order->total_price,
                            $order->total_points,
                            $order->discounts ?? 0,
                            $order->delivery_city ?? $order->billing_city ?? '',
                            $order->delivery_state ?? $order->billing_state ?? '',
                            $order->delivery_country ?? $order->billing_country ?? '',
                            $order->delivery_street_address ?? $order->pickup_location,
                            $order->delivery_address_opt ?? $order->billing_address_opt,
                            $order->delivery_date ? 'Delivery' : 'Pickup',
                            $order->delivery_zip ?? $order->billing_zip ?? '',
                            $order->delivery_phone_number ?? $order->billing_phone_number ?? '',
                            ($order->delivery_date ?? $order->pickup_date)->format('m/d/Y') ?? '',
                            $order->delivery_time_frame_value ?? $order->pickup_time_frame_value ?? '',
                            $order->delivery_order_notes ?? '',
                        ],
                    ];
                }
                else{
                    $returnArray[] = [
                        0 => '',
                        1 => '',
                        2 => '',
                        3 => '',
                        4 => '',
                        5 => '',
                        6 => $mealNames[$i],
                        7 => $mealPrices[$i],
                        8 => '',
                        9 => '',
                        10 => '',
                        11 => '',
                        12 => '',
                        13 => '',
                    ];
                }
            }
        }
        else{
            $returnArray = [
                [
                    $order->created_at->format('m/d/Y'),
                    $order->id,
                    $user->first_name,
                    $user->last_name,
                    $user->email,
                    $mealNames[0],
                    $mealPrices[0],
                    $order->total_price,
                    $order->total_points,
                    $order->discounts ?? 0,
                    $order->delivery_city ?? $order->billing_city ?? '',
                    $order->delivery_state ?? $order->billing_state ?? '',
                    $order->delivery_country ?? $order->billing_country ?? '',
                    $order->delivery_street_address ?? $order->pickup_location,
                    $order->delivery_address_opt ?? $order->billing_address_opt ?? '',
                    $order->delivery_date ? 'Delivery' : 'Pickup',
                    $order->delivery_zip ?? $order->billing_zip ?? '',
                    $order->delivery_phone_number ?? $order->billing_phone_number ?? '',
                    ($order->delivery_date ?? $order->pickup_date)->format('m/d/Y') ?? '',
                    $order->delivery_time_frame_value ?? $order->pickup_time_frame_value ?? '',
                    $order->delivery_order_notes ?? '',
                ],
            ];
        }
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
        $len = count($entry) > count($sides) ? count($entry) : count($sides) ;
        for ($i = 1; $i <= $len; $i++){
            $e = array_shift($entry);
            $s = array_shift($sides);
            $returnArray[] = [
                '',
                '',
                '',
                '',
                '',
                $e === null ? '' : ($e['count'] === 1 ? '' : $e['count']) . ' ' . $e['name'],
                $s === null ? '' : ($s['count'] === 1 ? '' : $s['count']) . ' ' . $s['name'],
            ];
        }

        return $returnArray;
    }

    public function headings(): array
    {
        return [
            'SUBMITTED ON',
            'YOUR ORDER',
            'FIRST NAME',
            'LAST NAME',
            'EMAIL',
            'MEAL NAME',
            'MEAL PRICE',
            'TOTAL PRICE',
            'TOTAL POINTS',
            'DISCOUNTS',
            'CITY',
            'STATE',
            'COUNTRY',
            'DELIVERY ADDRESS',
            'APT/OPTIONAL',
            'TYPE',
            'ZIPCODE',
            'PHONE',
            'DELIVERY/PICKUP DATE',
            'TIME FRAME',
            'NOTES'
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'H'=>NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }
}
