<?php

namespace App\Http\Responses;

use App\Models\Setting;
use App\Notifications\Users\NewAdminRegisteredVerificationPending;
use App\Notifications\Users\VerifyNewAdminRegistration;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $user->notify(new NewAdminRegisteredVerificationPending($request->password));
            Notification::route('mail', Setting::getSupportEmail())->notify(new VerifyNewAdminRegistration($user));

            $redirectRouteName = 'backend.dashboard.index';
        } else {
            $redirectRouteName = 'frontend.dashboard.index';
        }

        return $request->wantsJson()
            ? response()->json(['csrf_token' => csrf_token()], 201)
            : redirect()->route($redirectRouteName);
    }
}
