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
            ->withBasicAuth('878bcef0a7524e3cb7897c99712681c1', 'DtxmbB21uh1yUJ9DpMyAjSp43h4J4HSY')
            ->post('https://oauth.battle.net/oauth/token', [
                'redirect_uri' => route('oauth'),
                'grant_type' => 'authorization_code',
                'code' => $request->get('code')
            ]);

        session()->put('user_token', $response->json()['access_token']);

        return redirect()->to(session('redirect_uri'));
    }
}
