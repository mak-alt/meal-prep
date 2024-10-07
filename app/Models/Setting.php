<?php

namespace App\Models;

use App\Services\FileUploaders\StorageFileUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;

class Setting extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'data',
    ];

    /**
     * @var string[]
     */
    protected $casts = ['data' => 'array'];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKey(Builder $query, string $name): Builder
    {
        return $query->where('key', $name);
    }

    /**
     * @return string
     */
    public static function getSupportEmail(): string
    {
        return self::key('support_email')->exists()
            ? self::key('support_email')->first()->data
            : env('MAIL_FROM_ADDRESS');
    }

    /**
     * @param bool $onlyDefault
     * @return array
     */
    public static function getMealsPortionSizes(bool $onlyDefault = false): array
    {
        $portionSizes = self::key('portion_sizes')->exists()
            ? self::key('portion_sizes')->first()->data
            : [['size' => '5', 'percentage' => '0']];

        if (!$onlyDefault) {
            return $portionSizes;
        }

        $defaultPortionSize = collect($portionSizes)->map(function (array $portionSize) {
            if ($portionSize['percentage'] === '0') {
                return $portionSize;
            }
        })->filter();

        return $defaultPortionSize->isNotEmpty()
            ? $defaultPortionSize->toArray()
            : [['size' => '5', 'percentage' => '0']];
    }

    /**
     * @return mixed|null
     */
    public static function getPaymentServicesCredentials()
    {
        return optional(Setting::key('payments_credentials')->first())->data ?? [
                'stripe_key'                => env('STRIPE_KEY'),
                'stripe_secret'             => env('STRIPE_SECRET'),
                'paypal_mode'               => env('PAYPAL_MODE'),
                'paypal_client_id'          => env('PAYPAL_CLIENT_ID'),
                'paypal_client_secret'      => env('PAYPAL_CLIENT_SECRET'),
                'payeezy_api'               => env('PAYMENT_API_KEY'),
                'payeezy_api_secret'        => env('PAYMENT_API_SECRET'),
                'payeezy_merchant_token'    => env('MERCHANT_TOKEN'),
            ];
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function updateOrCreateSettings(array $data = []): bool
    {
        if (!empty($data['thumb']) && $data['thumb'] instanceof UploadedFile) {
            $uploadedPath = StorageFileUploadService::store('public/uploads/landing/', $data['thumb']);

            if (!$uploadedPath) {
                return false;
            }

            $data['thumb'] = $uploadedPath;
        }

        if (!empty($data['thumb2']) && $data['thumb2'] instanceof UploadedFile) {
            $uploadedPath = StorageFileUploadService::store('public/uploads/landing/', $data['thumb2']);

            if (!$uploadedPath) {
                return false;
            }

            $data['thumb2'] = $uploadedPath;
        }

        foreach ($data as $key => $value) {
            self::updateOrCreate(
                ['key' => $key],
                ['key' => $key, 'data' => $value]
            );
        }

        return true;
    }
}
