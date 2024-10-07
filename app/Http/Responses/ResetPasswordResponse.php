<?php

namespace App\Http\Responses;

use App\Models\User;
use App\Models\UserRole;
use Laravel\Fortify\Contracts\PasswordResetResponse;

class ResetPasswordResponse implements PasswordResetResponse
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = User::whereEmail($request->email)->firstOrFail();

        $redirectRouteName = $user->isCustomer()
            ? 'frontend.landing.index'
            : 'backend.auth.login';

        setSessionResponseMessage('You have successfully changed your password. Now you can login.');

        return $request->wantsJson()
            ? response()->json(null, 204)
            : redirect()->route($redirectRouteName)->with('success', 'Your password has been reset!');
    }
}
