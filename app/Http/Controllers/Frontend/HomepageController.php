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
        //test request with user token
        /*$response = Http::withToken('EUQF8HLmggIRGlilXkYI3PuKV7Pn7qBiT5')
            ->get('https://eu.api.blizzard.com/profile/user/wow', [
                'namespace' => 'profile-eu',
                'locale' => 'fr_FR'
            ]);*/
        //return $response->json();
        //dd($response);
        return view('welcome', [
            'response' => $response->json(),
        ]);
        //return Inertia::render("Homepage");
    }

    public function test()
    {
        $streamers = [
            ['id' => 1, 'name' => 'Streamer 1', 'avatar' => 'https://via.placeholder.com/150', 'description' => 'Best streamer ever.'],
            // ... autres streamers
        ];

        $guides = [
            ['id' => 1, 'title' => 'Guide 1', 'summary' => 'This is a guide summary.', 'url' => '/guides/1'],
            // ... autres guides
        ];

        $achievements = [
            ['id' => 1, 'title' => 'Achievement 1', 'description' => 'User achievement description.', 'image' => 'https://via.placeholder.com/150'],
            // ... autres réalisations
        ];

        return Inertia::render('Homepage', [
            'streamers' => $streamers,
            'guides' => $guides,
            'achievements' => $achievements,
        ]);
    }
}
