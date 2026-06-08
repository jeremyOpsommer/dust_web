<?php

namespace App\Http\Controllers\BlizzardAPI;

use App\Http\Controllers\Controller;
use App\Models\OauthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class OAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $response = Http::asForm()
            ->withBasicAuth(config('blizzard.username'), config('blizzard.password'))
            ->post('https://oauth.battle.net/oauth/token', [
                'redirect_uri' => route('oauth'),
                'grant_type'   => 'authorization_code',
                'code'         => $request->get('code'),
            ]);

        $data = $response->json();

        if (auth()->check()) {
            OauthToken::updateOrCreate(
                ['user_id' => auth()->id(), 'provider' => 'blizzard'],
                [
                    'access_token' => $data['access_token'],
                    'expires_at'   => Carbon::now()->addSeconds($data['expires_in'] ?? 86400),
                ]
            );
        }

        // Conservé pour compatibilité avec le middleware session existant
        session()->put('user_token', $data['access_token']);

        return redirect()->to(session('redirect_uri'));
    }
}
