<?php

namespace App\Http\Controllers\Frontend;

use App\Blizzard\BlizzardAuth;
use App\Blizzard\WoW\GameData;
use App\Blizzard\WoW\Profile;
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

    //TODO refacto api blizzard
    public function test()
    {

        try {
            //test données jeu
            $gameDataAPI = new GameData('eu',url()->current());
            $response = $gameDataAPI->item(19019);
            //test données user
            //$profileAPI = new Profile('eu',url()->current());
            //$response = $profileAPI->accountSummary();
        }catch (RequestException $e) {
            abort(404, $e->getMessage());
        }
        return view('welcome', [
            'response' => $response,
        ]);

    }
}
