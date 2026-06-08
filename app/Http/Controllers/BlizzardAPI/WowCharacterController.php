<?php

namespace App\Http\Controllers\BlizzardAPI;

use App\Blizzard\WoW\Profile;
use App\Http\Controllers\Controller;
use App\Models\WowCharacter;
use Illuminate\Http\Request;

class WowCharacterController extends Controller
{
    private string $region = 'eu';

    /**
     * Retourne les personnages disponibles depuis l'API Blizzard
     */
    public function available()
    {
        $token = auth()->user()->getOauthToken('blizzard');

        if (!$token) {
            return response()->json(['error' => 'Non connecté à Battle.net'], 403);
        }

        session()->put('user_token', $token->access_token);

        $profile = new Profile($this->region, route('oauth'));
        $data    = $profile->accountSummary();

        $characters = collect($data['wow_accounts'] ?? [])
            ->flatMap(fn($account) => $account['characters'] ?? [])
            ->map(fn($char) => [
                'blizzard_id' => $char['id'],
                'name'        => $char['name'],
                'realm_slug'  => $char['realm']['slug'],
                'realm_name'  => $char['realm']['name'],
                'class_name'  => $char['playable_class']['name'],
                'level'       => $char['level'],
                'avatar_url'  => $this->avatarUrl($char['realm']['slug'], $char['id']),
            ])
            ->sortByDesc('level')
            ->values();

        return response()->json($characters);
    }

    /**
     * Ajoute un personnage en BDD
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->wowCharacters()->count() >= 5) {
            return back()->with('error', 'Vous avez atteint la limite de 5 personnages.');
        }

        $validated = $request->validate([
            'blizzard_id' => ['required', 'integer'],
            'name'        => ['required', 'string'],
            'realm_slug'  => ['required', 'string'],
            'realm_name'  => ['required', 'string'],
            'class_name'  => ['required', 'string'],
            'level'       => ['required', 'integer'],
        ]);

        WowCharacter::firstOrCreate(
            ['user_id' => $user->id, 'blizzard_id' => $validated['blizzard_id']],
            array_merge($validated, ['user_id' => $user->id, 'region' => $this->region])
        );

        return back()->with('success', "Personnage {$validated['name']} ajouté.");
    }

    /**
     * Supprime un personnage sauvegardé
     */
    public function destroy(WowCharacter $character)
    {
        abort_if($character->user_id !== auth()->id(), 403);

        $character->delete();

        return back()->with('success', "Personnage {$character->name} retiré.");
    }

    private function avatarUrl(string $realmSlug, int $id): string
    {
        return "https://render.worldofwarcraft.com/{$this->region}/character/{$realmSlug}/"
            . ($id % 256) . "/{$id}-avatar.jpg";
    }
}
