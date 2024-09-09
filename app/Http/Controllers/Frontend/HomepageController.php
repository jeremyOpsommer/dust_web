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
       
        dd($response);
        return view('welcome');
        //return Inertia::render("Homepage");
    }

    public function oauth(Request $request)
    {
        if($request->has('code')){
            //dd($request->get('code'));
            $response = Http::withBasicAuth('878bcef0a7524e3cb7897c99712681c1','DtxmbB21uh1yUJ9DpMyAjSp43h4J4HSY')
            ->accept('multipart/form-data')
            ->post('https://oauth.battle.net/oauth/token',[
                'grant_type' => 'authorization_code',
                'redirect_uri' => 'http://localhost/oauth',
                'code' => $request->get('code')
            ]);
            dd($response);
        }
        
        dd($request->all());
    }
}
