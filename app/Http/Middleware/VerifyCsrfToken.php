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
        'upload-file','quantumography_encode','quantumography_decode','quantumography/login','quantumography/login-or-register','quantumography/get-user-by-token'
    ];
}
