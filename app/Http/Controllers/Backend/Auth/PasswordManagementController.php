<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class PasswordManagementController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function forgotPasswordForm(): View
    {
        return \view('backend.auth.passwords.email');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function resetPasswordForm(): View
    {
        return \view('backend.auth.passwords.reset');
    }
}
