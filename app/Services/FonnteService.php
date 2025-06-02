<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $device_token;

    public const ENDPOINTS = [
        'send_message'  => 'https://api.fonnte.com/send',
    ];

    public function __construct()
    {
        $this->device_token = env('FONNTE_WHATSAPP_TOKEN');
    }

    protected function makeRequest($endpoint, $params = [])
    {
        $token = $this->device_token ?? null;

        if (!$token) {
            return ['status' => false, 'error' => 'API token or device token is required.'];
        }

        // Gunakan JSON format dan pastikan Content-Type header benar
        $response = Http::withHeaders([
            'Authorization' => $token,
            'Content-Type'  => 'application/json', // Tambahkan header
        ])->post($endpoint, $params);

        // Log respons untuk memudahkan debugging
        Log::info('Fonnte API Response', ['endpoint' => $endpoint, 'response' => $response->json()]);

        if ($response->failed()) {
            return [
                'status' => false,
                'error'  => $response->json()['reason'] ?? 'Unknown error occurred',
            ];
        }

        return [
            'status' => true,
            'data'   => $response->json(),
        ];
    }

    public function sendWhatsAppMessage($phoneNumber, $message)
    {
        return $this->makeRequest(self::ENDPOINTS['send_message'], [
            'target'  => $phoneNumber,
            'message' => $message,
        ]);
    }
}
