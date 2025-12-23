<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'login',
        'admin-management/login',
        'admin-management/game/set_winning_number',
        'admin-management/game/set_winning_number2',
        'admin-management/withdrawal_request/approve',
        'admin-management/withdrawal_request/reject',
    ];
}
