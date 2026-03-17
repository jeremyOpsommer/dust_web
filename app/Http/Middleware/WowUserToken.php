<?php

namespace App\Http\Middleware;

use App\Blizzard\BlizzardAuth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class WowUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->session()->has('user_token')){
            $request->session()->put('redirect_uri', url()->current());
            return redirect()
                ->away('https://oauth.battle.net/authorize?response_type=code&client_id='
                    .config('blizzard.username').'&redirect_uri='
                    .route('oauth').'&scope=wow.profile&state='
                    .Str::random(6));
        }
        return $next($request);
    }
}
