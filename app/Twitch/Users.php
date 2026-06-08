<?php

namespace App\Twitch;

use Illuminate\Support\Facades\Http;

class Users
{
    private string $baseUri = 'https://api.twitch.tv/helix';
    private string|null $token;
    private string $clientId;

    public function __construct()
    {
        $this->token    = session()->get('twitch_token');
        $this->clientId = config('twitch.client_id');
    }

    /**
     * Récupère les infos d'un utilisateur Twitch par son login.
     */
    public function getByLogin(string $login)
    {
        $response = Http::withToken($this->token)
            ->withHeader('Client-Id', $this->clientId)
            ->get($this->baseUri . '/users', ['login' => $login]);

        return $response->json();
    }

    /**
     * Récupère les infos d'un utilisateur Twitch par son id.
     */
    public function getById(string $id)
    {
        $response = Http::withToken($this->token)
            ->withHeader('Client-Id', $this->clientId)
            ->get($this->baseUri . '/users', ['id' => $id]);

        return $response->json();
    }

    /**
     * Récupère les infos de la chaîne d'un broadcaster (description, catégorie, etc.)
     */
    public function getChannel(string $broadcasterId)
    {
        $response = Http::withToken($this->token)
            ->withHeader('Client-Id', $this->clientId)
            ->get($this->baseUri . '/channels', ['broadcaster_id' => $broadcasterId]);

        return $response->json();
    }

    /**
     * Recherche des chaînes par nom.
     */
    public function searchChannels(string $query, int $first = 20)
    {
        $response = Http::withToken($this->token)
            ->withHeader('Client-Id', $this->clientId)
            ->get($this->baseUri . '/search/channels', [
                'query' => $query,
                'first' => $first,
            ]);

        return $response->json();
    }
}
