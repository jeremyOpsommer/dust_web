<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\WowInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('User/Index', [
            'user'              => $user?->only('name', 'email', 'created_at', 'updated_at'),
            'blizzardConnected' => $user?->getOauthToken('blizzard') !== null,
            'wowInstances'      => WowInstance::all()->keyBy('blizzard_id')
                ->map(fn($i) => [
                    'name_en'           => $i->name_en,
                    'name_fr'           => $i->name_fr,
                    'expansion_id'      => $i->expansion_id,
                    'expansion_name_en' => $i->expansion_name_en,
                    'expansion_name_fr' => $i->expansion_name_fr,
                    'season'            => $i->season,
                ])
                ->all(),
            'wowCharacters'     => $user?->wowCharacters()
                ->orderByDesc('level')
                ->get()
                ->map(fn($c) => [
                    'id'               => $c->id,
                    'blizzard_id'      => $c->blizzard_id,
                    'name'             => $c->name,
                    'realm_name'       => $c->realm_name,
                    'class_name'       => $c->class_name,
                    'level'            => $c->level,
                    'avatar_url'       => $c->getAvatarUrl(),
                    'can_refresh'      => $c->canRefresh(),
                    'last_refreshed_at' => $c->last_refreshed_at?->format('d/m/Y H:i'),
                    'stats'            => $c->stats,
                    'equipment'        => $c->equipment,
                    'pve_progression'  => $c->pve_progression,
                ]) ?? [],
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $validated['name'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour.');
    }
}
