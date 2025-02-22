<?php

namespace App\Blizzard\WoW;

use App\Blizzard\BlizzardAuth;
use Illuminate\Support\Facades\Http;

class GameData
{
    public string $region;
    public string $redirectUri;
    private string $baseUri;
    private string | null $token;

    public function __construct(string $region, string $redirectUri)
    {
        $this->region = $region;
        $this->redirectUri = $redirectUri;
        $this->baseUri = 'https://'.$this->region.'.api.blizzard.com/data/wow';
        $this->token = session()->get('client_token');
    }

    public function item($id)
    {
        $response = Http::withToken($this->token)
            ->get($this->baseUri.'/item/'.$id, [
                'namespace' => 'static-'.$this->region,
                'locale' => 'fr_FR'
            ]);

        return $response->json();
    }
}
