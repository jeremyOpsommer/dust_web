<?php

namespace App\Http\Controllers\BlizzardAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $response = Http::asForm()
            ->withBasicAuth(config('blizzard.username'), config('blizzard.password'))
            ->post('https://oauth.battle.net/oauth/token', [
                'redirect_uri' => route('oauth'),
                'grant_type' => 'authorization_code',
                'code' => $request->get('code')
            ]);

        session()->put('user_token', $response->json()['access_token']);

        return redirect()->to(session('redirect_uri'));
    }
}
