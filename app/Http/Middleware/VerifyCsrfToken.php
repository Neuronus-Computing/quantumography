<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'upload-file','vangonography_encode','vangonography_decode','vangonography/login','vangonography/login-or-register','vangonography/get-user-by-token'
    ];
}
