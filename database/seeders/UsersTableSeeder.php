<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * @var array
     */
    protected array $adminData = [
        'name'     => 'Admin',
        'email'    => 'admin@admin.com',
        'role'     => User::ROLES['admin'],
        'password' => 'admin@admin.com',
    ];

    /**
     * @var array
     */
    protected array $userData = [
        'name'     => 'User',
        'email'    => 'user@user.com',
        'role'     => User::ROLES['user'],
        'password' => 'user@user.com',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            if ($i === 1) {
                User::updateOrCreate(
                    ['email' => $this->adminData['email']],
                    [
                        'name'     => $this->adminData['name'],
                        'email'    => $this->adminData['email'],
                        'role'     => $this->adminData['role'],
                        'password' => Hash::make($this->adminData['password']),
                    ]
                );
            }

            $email = str_replace('user@', "user$i@", $this->userData['email']);
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'          => $this->userData['name'] . " $i",
                    'email'         => $email,
                    'role'          => $this->userData['role'],
                    'password'      => Hash::make($email),
                    'referral_code' => Str::random(),
                ]
            );
        }
    }
}
