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
        $token = session()->get('client_token');
        //test request with client token
        $response = Http::withToken($token)
            ->get('https://eu.api.blizzard.com/data/wow/item/19019', [
                'namespace' => 'static-eu',
                'locale' => 'fr_FR'
            ]);
        dd($response->json());
        //test request with user token
        /*$response = Http::withToken('EUQF8HLmggIRGlilXkYI3PuKV7Pn7qBiT5')
            ->get('https://eu.api.blizzard.com/profile/user/wow', [
                'namespace' => 'profile-eu',
                'locale' => 'fr_FR'
            ]);*/
        //dd($response);
        return $response->json();
        return view('welcome');
        //return Inertia::render("Homepage");
    }
}
