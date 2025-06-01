<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SpotifyService
{
    const SUPPORT_DETAIL_TYPES = ['artist', 'album', 'track', 'playlist'];

    private $baseUrl;
    private $accessTokenUrl;
    private $token;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.spotify.base_url');
        $this->accessTokenUrl = config('services.spotify.access_token_url');
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
        $this->token = $this->getAccessToken();

        if (empty($this->clientId) || empty($this->clientSecret)) {
            throw new \Exception('Spotify client id or secret not found');
        }

        if (empty($this->baseUrl)) {
            throw new \Exception('Spotify URL not found');
        }
    }
    public function detail(string $type, string $id): array
    {
        if (!collect(self::SUPPORT_DETAIL_TYPES)->contains($type)) {
            throw new \Exception('Spotify detail type not supported');
        }

        $response = Http::withToken($this->token)
            ->get($this->baseUrl . '/' . $type . '/' . $id);

        if (!$response->ok()) {
            return ['error' => 'Spotify detail failed'];
        }

        return $response->json();
    }

    public function search(array $query, int $limit = 10, int $offset = 0): array
    {
        $queryString = array_merge($query, ['limit' => $limit, 'offset' => $offset]);

        $response = Http::withToken($this->token)
            ->get($this->baseUrl . '/search', $queryString);

        if (!$response->ok()) {
            return ['error' => 'Spotify search failed'];
        }

        return $response->json();
    }

    public function recommendations(array $seeds, int $limit = 10, int $offset = 0): array
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

    private function getAccessToken()
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($this->accessTokenUrl, [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            throw new \Exception('Spotify access token request failed');
        }

        return $response['access_token'];
    }
}
