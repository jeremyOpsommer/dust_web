<?php

namespace App\Http\Middleware;

use App\Blizzard\BlizzardAuth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class BlizzardClientToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //TODO régler la région
        if(!session()->has('client_token')){
            $response = Http::asForm()
                ->withBasicAuth(config('blizzard.username'), config('blizzard.password'))
                ->post('https://oauth.battle.net/token', [
                    'region' => 'eu',
                    'grant_type' => 'client_credentials',
                ]);
            session()->put('client_token', $response->json()['access_token']);
        }
        return $next($request);
    }
}
