<?php

namespace App\Actions\Fortify;

use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Rules\Password;
use Newsletter;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return \App\Models\User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input): User
    {
        $passwordValidationRules = ['required', 'string', 'confirmed', (new Password)->requireUppercase()->requireSpecialCharacter()];

        Validator::make($input, [
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'name'          => ['required', 'string', 'max:255', 'unique:users,name'],
            'email'         => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password'      => $passwordValidationRules,
        ])->validate();

        if ( !empty($input['subscribe_to_updates'])
            && !NewsletterSubscriber::where('email', $input['email'])->exists()
            && !Newsletter::isSubscribed($input['email'])
        ) {
            Newsletter::subscribe($input['email']);
            NewsletterSubscriber::storeSubscriber(['email' => $input['email']]);
        }

        return User::create([
            'name'          => $input['name'],
            'email'         => $input['email'],
            'role'          => User::ROLES['user'],
            'status'        => User::STATUSES['active'],
            'password'      => Hash::make($input['password']),
            'referral_code' => Str::random(),
            'first_name'    => $input['first_name'],
            'last_name'     => $input['last_name'],
        ]);
    }
}
