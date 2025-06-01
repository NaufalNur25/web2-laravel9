<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Enums\Emotion;

class EmotionDetectionService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ai_emotion.url');

        if (empty($this->baseUrl)) {
            throw new \Exception('AI Emotion URL not found');
        }
    }

    public function detectEmotion(string $text): ?Emotion
    {
        $response = Http::post($this->baseUrl, [
            'text' => $text,
        ]);

        if (!$response->ok() || !isset($response['emotion'])) {
            return null;
        }

        return Emotion::fromString($response['emotion']);
    }

    public function detectEmotionRaw(string $text): array
    {
        $response = Http::post($this->baseUrl, [
            'text' => $text,
        ]);

        return $response->json();
    }
}
