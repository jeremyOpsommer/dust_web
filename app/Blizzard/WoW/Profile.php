<?php

namespace App\Blizzard\WoW;

use App\Blizzard\BlizzardAuth;
use Illuminate\Support\Facades\Http;
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
                'locale' => 'fr_FR'
            ]);

        return $response->json();
    }
}
