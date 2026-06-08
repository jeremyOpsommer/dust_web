<?php

namespace App\Http\Controllers\BlizzardAPI;

use App\Http\Controllers\Controller;
use App\Models\OauthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    /**
     * Redirige l'utilisateur vers la page d'autorisation Battle.net
     */
    public function redirect()
    {
        $state = Str::random(16);
        session()->put('blizzard_oauth_state', $state);
        session()->put('redirect_uri', route('user.index'));

        $query = http_build_query([
            'response_type' => 'code',
            'client_id'     => config('blizzard.username'),
            'redirect_uri'  => route('oauth'),
            'scope'         => 'wow.profile',
            'state'         => $state,
        ]);

        return redirect()->away('https://oauth.battle.net/authorize?' . $query);
    }

    /**
     * Callback Battle.net : échange le code contre un token et le stocke en BDD
     */
    public function callback(Request $request)
    {
        abort_if($request->get('state') !== session('blizzard_oauth_state'), 403, 'State invalide.');

        $response = Http::asForm()
            ->withBasicAuth(config('blizzard.username'), config('blizzard.password'))
            ->post('https://oauth.battle.net/oauth/token', [
                'redirect_uri' => route('oauth'),
                'grant_type'   => 'authorization_code',
                'code'         => $request->get('code'),
            ]);

        $data        = $response->json();
        $accessToken = $data['access_token'];

        // Récupère l'identifiant Battle.net du compte
        $userInfo       = Http::withToken($accessToken)->get('https://oauth.battle.net/userinfo')->json();
        $providerUserId = (string) ($userInfo['id'] ?? $userInfo['sub'] ?? null);

        if (auth()->check()) {
            // Vérifie que ce compte Battle.net n'est pas déjà lié à un autre utilisateur
            $existing = OauthToken::where('provider', 'blizzard')
                ->where('provider_user_id', $providerUserId)
                ->where('user_id', '!=', auth()->id())
                ->exists();

            if ($existing) {
                return redirect()->to(route('user.index'))
                    ->with('error', 'Ce compte Battle.net est déjà lié à un autre utilisateur.');
            }

            OauthToken::updateOrCreate(
                ['user_id' => auth()->id(), 'provider' => 'blizzard'],
                [
                    'provider_user_id' => $providerUserId,
                    'access_token'     => $accessToken,
                    'expires_at'       => Carbon::now()->addSeconds($data['expires_in'] ?? 86400),
                ]
            );
        }

        session()->put('user_token', $accessToken);

        return redirect()->to(session('redirect_uri', route('user.index')));
    }
}
