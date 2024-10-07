<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItemable extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_item_id',
        'order_itemable_id',
        'order_itemable_type',
        'parent_id',
        'price',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function orderItemable(): MorphTo
    {
        return $this->morphTo()->withDefault([
            'name'     => '-',
            'calories' => '',
            'fats'     => '',
            'proteins' => '',
            'carbs'    => '',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @param int $orderItemId
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return static|null
     */
    public static function storeParentOrderItemable(int $orderItemId, Model $model): ?self
    {
        return self::create([
            'order_item_id'       => $orderItemId,
            'order_itemable_id'   => $model->id,
            'order_itemable_type' => get_class($model),
            'parent_id'           => null,
            'price'               => $model->price,
        ]);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function storeChildOrderItemables(array $data): bool
    {
        $dataFormattedForInserting = [];

        foreach ($data as $model) {
            if ($model !== null) {
                $dataFormattedForInserting[] = [
                    'order_item_id'       => $this->order_item_id,
                    'order_itemable_id'   => $model->id,
                    'order_itemable_type' => get_class($model),
                    'parent_id'           => $this->id,
                    'price'               => $model->pivot->price ?? $model->price,
                    'updated_at'          => now(),
                    'created_at'          => now(),
                ];
            }
        }

        self::insert($dataFormattedForInserting);

        return true;
    }
}
