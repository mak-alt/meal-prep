<?php

namespace App\View\Composers;

use Illuminate\View\View;

class AuthStatusComposer
{
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     * @throws \Exception
     */
    public function compose(View $view): void
    {
        $isAuthenticated = auth()->check();

        $view->with('isAuthenticated', $isAuthenticated);
    }
}
