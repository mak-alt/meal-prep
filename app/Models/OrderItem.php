<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'menu_id',
        'name',
        'portion_size',
        'total_price',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItemables(): HasMany
    {
        return $this->hasMany(OrderItemable::class);
    }

    /**
     * @param array $data
     * @return static|null
     */
    public static function storeOrderItem(array $data): ?self
    {
        return self::create([
            'order_id'    => $data['order_id'],
            'menu_id'     => $data['menu_id'],
            'name'        => !empty($data['menu'])
                ? $data['menu']->name . " ({$data['items_amount']} meals)"
                : "Custom meal plan ({$data['items_amount']} meals)",
            'total_price' => $data['total_price'],
            'portion_size' => $data['portion_size'],
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function storeOrderItemItemables(array $data): bool
    {
        $orderItemId = $this->id;

        foreach ($data['items'] as $itemData) {
            $orderItemable = OrderItemable::storeParentOrderItemable($orderItemId, $itemData[0]);
            $orderItemable->storeChildOrderItemables($itemData['sides']);
        }

        foreach ($data['addons'] as $addonData) {
            $orderItemable = OrderItemable::storeParentOrderItemable($orderItemId, $addonData[0]);
            $orderItemable->storeChildOrderItemables($addonData['meals']);
        }

        return true;
    }
}
