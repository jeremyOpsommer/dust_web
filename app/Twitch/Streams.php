<?php

namespace App\Twitch;

use Illuminate\Support\Facades\Http;

class Streams
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
     * Récupère les streams en live.
     * Filtrable par login(s) de streamer, game_id, langue, etc.
     *
     * @param array $params Ex: ['user_login' => 'pseudo', 'first' => 20]
     */
    public function getLiveStreams(array $params = [])
    {
        $response = Http::withToken($this->token)
            ->withHeader('Client-Id', $this->clientId)
            ->get($this->baseUri . '/streams', $params);

        return $response->json();
    }

    /**
     * Récupère le stream en live d'un streamer par son login.
     */
    public function getStreamByLogin(string $login)
    {
        return $this->getLiveStreams(['user_login' => $login]);
    }

    /**
     * Récupère les streams en live d'une liste de streamers.
     * Twitch requiert des paramètres répétés : user_login=a&user_login=b
     *
     * @param string[] $logins
     */
    public function getStreamsByLogins(array $logins)
    {
        $query = implode('&', array_map(fn($l) => 'user_login=' . urlencode($l), $logins));

        $response = Http::withToken($this->token)
            ->withHeader('Client-Id', $this->clientId)
            ->get($this->baseUri . '/streams?' . $query);

        return $response->json();
    }
}
