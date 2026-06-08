<?php

namespace App\Http\Controllers\TwitchAPI;

use App\Http\Controllers\Controller;
use App\Models\OauthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    /**
     * Redirige l'utilisateur vers la page d'autorisation Twitch.
     */
    public function redirect()
    {
        $state = Str::random(16);
        session()->put('twitch_oauth_state', $state);
        session()->put('twitch_redirect_uri', url()->previous());

        $query = http_build_query([
            'client_id'     => config('twitch.client_id'),
            'redirect_uri'  => route('twitch.oauth.callback'),
            'response_type' => 'code',
            'scope'         => 'user:read:email',
            'state'         => $state,
        ]);

        return redirect()->away('https://id.twitch.tv/oauth2/authorize?' . $query);
    }

    /**
     * Callback Twitch : échange le code contre un token et le stocke en BDD.
     */
    public function callback(Request $request)
    {
        abort_if($request->get('state') !== session('twitch_oauth_state'), 403, 'State invalide.');

        $response = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
            'client_id'     => config('twitch.client_id'),
            'client_secret' => config('twitch.client_secret'),
            'code'          => $request->get('code'),
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => route('twitch.oauth.callback'),
        ]);

        $data = $response->json();

        OauthToken::updateOrCreate(
            ['user_id' => auth()->id(), 'provider' => 'twitch'],
            [
                'access_token'  => $data['access_token'],
                'refresh_token' => $data['refresh_token'] ?? null,
                'expires_at'    => Carbon::now()->addSeconds($data['expires_in'] ?? 14400),
            ]
        );

        return redirect()->to(session('twitch_redirect_uri', route('user.index')));
    }
}
