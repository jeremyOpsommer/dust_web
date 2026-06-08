<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TwitchClientToken
{
    /**
     * Récupère un App Access Token Twitch (Client Credentials)
     * et le stocke en session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('twitch_token')) {
            $response = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
                'client_id'     => config('twitch.client_id'),
                'client_secret' => config('twitch.client_secret'),
                'grant_type'    => 'client_credentials',
            ]);

            session()->put('twitch_token', $response->json()['access_token']);
        }

        return $next($request);
    }
}
