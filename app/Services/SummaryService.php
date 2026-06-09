<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SummaryService
{
    public function summarize($text)
    {
        if (!$text) return null;

        try {

            $response = Http::timeout(120)->post(
                'http://127.0.0.1:9000/summary',
                [
                    'text' => $text
                ]
            );

            if (!$response->successful()) {
                return null;
            }

            return $response->json()['summary'] ?? null;

        } catch (\Throwable $e) {

            return null;
        }
    }
}