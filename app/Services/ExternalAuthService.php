<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalAuthService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('RESONANCE_API_URL');
    }

    public function registerUserWithSeed($seed)
    {
        return Http::post("{$this->baseUrl}/register", ['seed' => $seed]);
    }
    public function getAuthUser($token)
    {
        return Http::withHeaders([
            'authorization' => "$token"
        ])->get("{$this->baseUrl}/authenticated");
    }

    public function getSeed()
    {
        return Http::get("{$this->baseUrl}/register");
    }

    public function loginUserWithSeed($seed)
    {
        return Http::post("{$this->baseUrl}/login", ['seed' => $seed]);
    }
    
    public function getWordPool()
    {
        return Http::get("{$this->baseUrl}/get-word-pool");
    }
}
