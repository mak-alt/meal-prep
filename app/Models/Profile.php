<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'display_name',
        'delivery_first_name',
        'delivery_last_name',
        'delivery_country',
        'delivery_state',
        'delivery_city',
        'delivery_street_address',
        'delivery_address_opt',
        'delivery_zip',
        'delivery_company_name',
        'delivery_phone_number',
        'billing_first_name',
        'billing_last_name',
        'billing_country',
        'billing_state',
        'billing_city',
        'billing_street_address',
        'billing_address_opt',
        'billing_zip',
        'billing_company_name',
        'billing_phone_number',
        'billing_email_address',
    ];

    /**
     * @param string|null $value
     */
    public function setDeliveryFirstNameAttribute(?string $value): void
    {
        $this->attributes['delivery_first_name'] = $value ? ucfirst($value) : null;
    }

    /**
     * @param string|null $value
     */
    public function setDeliveryLastNameAttribute(?string $value): void
    {
        $this->attributes['delivery_last_name'] = $value ? ucfirst($value) : null;
    }

    /**
     * @param string|null $value
     */
    public function setBillingFirstNameAttribute(?string $value): void
    {
        $this->attributes['billing_first_name'] = $value ? ucfirst($value) : null;
    }

    /**
     * @param string|null $value
     */
    public function setBillingLastNameAttribute(?string $value): void
    {
        $this->attributes['billing_last_name'] = $value ? ucfirst($value) : null;
    }

    /**
     * @param string|null $value
     */
    public function setDisplayNameAttribute(?string $value): void
    {
        $this->attributes['display_name'] = $value ? ucfirst($value) : null;
    }

    /**
     * @param array $data
     * @param \App\Models\User|null $user
     * @param bool $updateName
     * @return mixed
     */
    public static function updateOrCreatePersonalDetails(array $data, ?User $user = null, bool $updateName = true)
    {
        if (!$user) {
            $user = auth()->user();
        }

        $data['user_id'] = $user->id;

        if ($updateName) {
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'name' => $data['name'],
            ]);
        }

        return self::updateOrCreate(['user_id' => $data['user_id']], $data);
    }

    /**
     * @param array $data
     * @param \App\Models\User|null $user
     * @return bool
     */
    public static function updateOrCreateDeliveryAddress(array $data, ?User $user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'delivery_first_name'     => $data['delivery_first_name'] ?? null,
                'delivery_last_name'      => $data['delivery_last_name'] ?? null,
                'delivery_country'        => $data['delivery_country'],
                'delivery_state'          => $data['delivery_state'],
                'delivery_city'           => $data['delivery_city'],
                'delivery_street_address' => $data['delivery_street_address'],
                'delivery_address_opt'    => $data['delivery_address_opt'] ?? null,
                'delivery_zip'            => $data['delivery_zip'],
                'delivery_company_name'   => $data['delivery_company_name'],
                'delivery_phone_number'   => $data['delivery_phone_number'],
            ]
        );

        if (isset($data['delivery_use_address_as_billing_address'])) {
            $user->profile()->update([
                'billing_country'        => $data['delivery_country'],
                'billing_state'          => $data['delivery_state'],
                'billing_city'           => $data['delivery_city'],
                'billing_street_address' => $data['delivery_street_address'],
                'billing_address_opt'    => $data['delivery_address_opt'] ?? null,
                'billing_zip'            => $data['delivery_zip'],
                'billing_company_name'   => $data['delivery_company_name'],
                'billing_phone_number'   => $data['delivery_phone_number'],
            ]);
        }

        return true;
    }

    /**
     * @param array $data
     * @param \App\Models\User|null $user
     * @return bool
     */
    public static function updateOrCreateBillingAddress(array $data, ?User $user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'billing_first_name'     => $data['billing_first_name'] ?? null,
                'billing_last_name'      => $data['billing_last_name'] ?? null,
                'billing_country'        => $data['billing_country'],
                'billing_state'          => $data['billing_state'],
                'billing_city'           => $data['billing_city'],
                'billing_street_address' => $data['billing_street_address'],
                'billing_address_opt'    => $data['billing_address_opt'] ?? null,
                'billing_zip'            => $data['billing_zip'],
                'billing_company_name'   => $data['billing_company_name'],
                'billing_phone_number'   => $data['billing_phone_number'],
                'billing_email_address'  => $data['billing_email_address'],
            ]
        );

        if (isset($data['billing_use_address_as_delivery_address'])) {
            $user->profile()->update([
                'delivery_country'        => $data['billing_country'],
                'delivery_state'          => $data['billing_state'],
                'delivery_city'           => $data['billing_city'],
                'delivery_street_address' => $data['billing_street_address'],
                'delivery_address_opt'    => $data['billing_address_opt'] ?? null,
                'delivery_zip'            => $data['billing_zip'],
                'delivery_company_name'   => $data['billing_company_name'],
                'delivery_phone_number'   => $data['billing_phone_number'],
            ]);
        }

        return true;
    }
}
