<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $redirectRouteName = auth()->user()->isAdmin()
            ? 'backend.dashboard.index'
            : 'frontend.dashboard.index';

        return $request->wantsJson()
            ? response()->json(['two_factor' => false, 'csrf_token' => csrf_token()])
            : redirect()->route($redirectRouteName);
    }
}
