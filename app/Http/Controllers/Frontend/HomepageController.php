<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

class HomepageController extends Controller
{
    public function index()
    {
        //test request with client token
        $response = Http::withToken('EU9PkOxHhfQzldWQLnG910HSPoVbCpPyVz')
            ->get('https://eu.api.blizzard.com/data/wow/item/19019',[
                'namespace' => 'static-eu',
                'locale' => 'fr_FR'
            ]);
        dd($response->json());
        //test request with user token
        $response = Http::withToken('EUQF8HLmggIRGlilXkYI3PuKV7Pn7qBiT5')
            ->get('https://eu.api.blizzard.com/profile/user/wow',[
                'namespace' => 'profile-eu',
                'locale' => 'fr_FR'
            ]);
        //dd($response);
        return $response->json();
        return view('welcome');
        //return Inertia::render("Homepage");
    }

    public function oauth(Request $request)
    {
        //user token
        if($request->has('code')){
            //dd($request->get('code'));
            $response = Http::asForm()
                ->withBasicAuth('878bcef0a7524e3cb7897c99712681c1','DtxmbB21uh1yUJ9DpMyAjSp43h4J4HSY')
                ->post('https://oauth.battle.net/oauth/token',[
                    'redirect_uri' => 'http://localhost/oauth',
                    'grant_type' => 'authorization_code',
                    'code' => $request->get('code')
                ]);
            dd($response->json());
        }else{
            $response = Http::asForm()
                ->withBasicAuth('878bcef0a7524e3cb7897c99712681c1','DtxmbB21uh1yUJ9DpMyAjSp43h4J4HSY')
                ->post('https://oauth.battle.net/oauth/token',[
                    'region' => 'eu',
                    'grant_type' => 'client_credentials',
                ]);
            dd($response->json());
        }

        dd($request->all());
    }
}
