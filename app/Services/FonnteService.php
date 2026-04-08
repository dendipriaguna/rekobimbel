<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected string $token;
    protected string $url;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->url = config('services.fonnte.url');
    }

    public function send(string $target, string $message): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->asForm()->post($this->url, [
                    'target' => $target,
                    'message' => $message,
                    'delay' => 2,
                ]);

        $result = $response->json();
        \Illuminate\Support\Facades\Log::info('Fonnte Response: ', $result ?? []);

        return $result;
    }
}