<?php

namespace App\Blizzard\WoW;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Profile
{
    public string $region;
    public string $redirectUri;
    private string $baseUri;
    private string | null $clientToken;
    private string | null $userToken;

    public function __construct(string $region, string $redirectUri)
    {
        $this->region = $region;
        $this->redirectUri = $redirectUri;
        $this->baseUri = 'https://'.$this->region.'.api.blizzard.com/profile';
        $this->clientToken = session()->get('client_token');
        $this->userToken = session()->get('user_token');
    }

    public function accountSummary()
    {
        $response = Http::withToken($this->userToken)
            ->get($this->baseUri.'/user/wow', [
                'namespace' => 'profile-'.$this->region,
                'locale'    => 'fr_FR',
            ]);

        return $response->json();
    }

    public function characterSummary(string $realmSlug, string $characterName)
    {
        return $this->characterRequest($realmSlug, $characterName, '');
    }

    public function characterEquipment(string $realmSlug, string $characterName)
    {
        return $this->characterRequest($realmSlug, $characterName, 'equipment');
    }

    public function characterStats(string $realmSlug, string $characterName)
    {
        return $this->characterRequest($realmSlug, $characterName, 'statistics');
    }

    public function characterRaids(string $realmSlug, string $characterName)
    {
        return $this->characterRequest($realmSlug, $characterName, 'encounters/raids');
    }

    private function characterRequest(string $realmSlug, string $characterName, string $endpoint): ?array
    {
        $name   = rawurlencode(mb_strtolower($characterName, 'UTF-8'));
        $realm  = rawurlencode(mb_strtolower($realmSlug, 'UTF-8'));
        $url = $endpoint
            ? "{$this->baseUri}/wow/character/{$realm}/{$name}/{$endpoint}"
            : "{$this->baseUri}/wow/character/{$realm}/{$name}";

        $response = Http::withToken($this->userToken)
            ->get($url, [
                'namespace' => 'profile-'.$this->region,
                'locale'    => 'fr_FR',
            ]);

        if (!$response->successful()) {
            Log::warning("Blizzard API [{$endpoint}] {$response->status()}", [
                'url'  => $url,
                'body' => $response->body(),
            ]);
            return null;
        }

        return $response->json();
    }
}
