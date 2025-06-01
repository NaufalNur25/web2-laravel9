<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpotifyService
{
    const ACCESS_TOKEN_URL = 'https://accounts.spotify.com/api/token';

    private $baseUrl;
    private $token;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->token = $this->getAccessToken();
        $this->baseUrl = config('services.spotify.url');
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');

        if (empty($this->clientId) || empty($this->clientSecret)) {
            throw new \Exception('Spotify client id or secret not found');
        }

        if (empty($this->baseUrl)) {
            throw new \Exception('Spotify URL not found');
        }
    }

    private function getAccessToken()
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
            ->post(self::ACCESS_TOKEN_URL, [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            throw new \Exception('Spotify access token request failed');
        }

        return $response['access_token'];
    }

    public function search(array $query, int $limit = 10, int $offset = 1): array
    {
        $queryString = array_merge($query, ['limit' => $limit, 'offset' => $offset]);

        $response = Http::withToken(self::getAccessToken())
            ->get($this->baseUrl . '/search', $queryString);

        if (!$response->ok()) {
            return ['error' => 'Spotify search failed'];
        }

        return $response->json();
    }

    public function getRecommendations(array $seeds, int $limit = 10, int $offset = 1): array
    {
        if (empty($seeds)) {
            return ['error' => 'At least one seed parameter is required'];
        }

        $query = array_merge($seeds, ['limit' => $limit, 'offset' => $offset]);

        $response = Http::withToken($this->token)
            ->get($this->baseUrl . '/recommendations', $query);

        if (!$response->ok()) {
            return ['error' => 'Spotify recommendations failed', 'details' => $response->json()];
        }

        return $response->json();
    }
}
