<?php

namespace App\Http\Controllers\BlizzardAPI;

use App\Blizzard\WoW\Profile;
use App\Http\Controllers\Controller;
use App\Models\WowCharacter;
use App\Models\WowInstance;
use Illuminate\Support\Facades\Log;

class WowCharacterRefreshController extends Controller
{
    public function __invoke(WowCharacter $character)
    {
        abort_if($character->user_id !== auth()->id(), 403);

        if (!$character->canRefresh()) {
            $next = $character->last_refreshed_at->addHour()->diffForHumans();
            return back()->with('error', "Prochain rafraîchissement disponible {$next}.");
        }

        $token = auth()->user()->getOauthToken('blizzard');
        abort_if(!$token, 403, 'Compte Battle.net non connecté.');

        session()->put('user_token', $token->access_token);

        $profile = new Profile($character->region, route('oauth'));

        $summaryRaw   = $profile->characterSummary($character->realm_slug, $character->name);
        $statsRaw     = $profile->characterStats($character->realm_slug, $character->name);
        $equipmentRaw = $profile->characterEquipment($character->realm_slug, $character->name);
        $raidsRaw     = $profile->characterRaids($character->realm_slug, $character->name);

        if (!$summaryRaw && !$statsRaw && !$equipmentRaw && !$raidsRaw) {
            return back()->with('error', "Impossible de récupérer les données de {$character->name}. Le token Battle.net est peut-être expiré.");
        }

        $character->update([
            'stats'             => $statsRaw     ? $this->parseStats($statsRaw, $summaryRaw) : $character->stats,
            'equipment'         => $equipmentRaw ? $this->parseEquipment($equipmentRaw)      : $character->equipment,
            'pve_progression'   => $raidsRaw     ? $this->parsePve($raidsRaw)                : $character->pve_progression,
            'last_refreshed_at' => now(),
        ]);

        return back()->with('success', "Personnage {$character->name} mis à jour.");
    }

    private function parseStats(array $data, ?array $summary = null): array
    {
        return [
            'item_level'      => $summary['equipped_item_level'] ?? $summary['average_item_level'] ?? null,
            'stamina'         => $data['stamina']['effective'] ?? null,
            'strength'        => $data['strength']['effective'] ?? null,
            'agility'         => $data['agility']['effective'] ?? null,
            'intellect'       => $data['intellect']['effective'] ?? null,
            'critical_strike' => round($data['melee_crit']['rating_bonus'] ?? 0, 2),
            'haste'           => round($data['melee_haste']['rating_bonus'] ?? 0, 2),
            'mastery'         => round($data['mastery']['rating_bonus'] ?? 0, 2),
            'versatility'     => round($data['versatility_damage_done_bonus'] ?? 0, 2),
        ];
    }

    private function parseEquipment(array $data): array
    {
        return collect($data['equipped_items'] ?? [])
            ->map(fn($item) => [
                'slot'         => $item['slot']['type'] ?? null,
                'item_id'      => $item['item']['id'] ?? null,
                'enchantments' => collect($item['enchantments'] ?? [])
                    ->pluck('enchantment_id')
                    ->values()
                    ->all(),
                'gems'         => collect($item['sockets'] ?? [])
                    ->filter(fn($s) => isset($s['item']['id']))
                    ->pluck('item.id')
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();
    }

    private function parsePve(array $data): array
    {
        $expansions = collect($data['expansions'] ?? []);

        // Priorité : "Current Season", sinon la dernière extension avec du contenu sorti
        $latestExpansion = $expansions->first(fn($e) => str_contains($e['expansion']['name'] ?? '', 'Current Season'))
            ?? $expansions
                ->sortByDesc('expansion.id')
                ->first(fn($e) => collect($e['instances'] ?? [])
                    ->some(fn($i) => collect($i['modes'] ?? [])
                        ->some(fn($m) => ($m['progress']['total_count'] ?? 0) > 0)
                    )
                );

        if (!$latestExpansion) return [];

        $expansionId    = $latestExpansion['expansion']['id'] ?? null;
        $expansionNameEn = $latestExpansion['expansion']['name'] ?? null;

        return collect($latestExpansion['instances'] ?? [])
            ->map(function ($instance) use ($expansionId, $expansionNameEn) {
                $blizzardId = $instance['instance']['id'] ?? null;
                $nameEn     = $instance['instance']['name'] ?? null;

                if ($blizzardId && $nameEn) {
                    WowInstance::updateOrCreate(
                        ['blizzard_id' => $blizzardId],
                        [
                            'name_en'          => $nameEn,
                            'expansion_id'     => $expansionId,
                            'expansion_name_en' => $expansionNameEn,
                        ]
                    );
                }

                return [
                    'instance_id' => $blizzardId,
                    'name'        => $nameEn,
                    'normal'      => $this->modeProgress($instance['modes'] ?? [], 'NORMAL'),
                    'heroic'      => $this->modeProgress($instance['modes'] ?? [], 'HEROIC'),
                    'mythic'      => $this->modeProgress($instance['modes'] ?? [], 'MYTHIC'),
                ];
            })
            ->values()
            ->all();
    }

    private function modeProgress(array $modes, string $type): array
    {
        $mode = collect($modes)->firstWhere('difficulty.type', $type);
        if (!$mode) return ['completed' => 0, 'total' => 0];

        return [
            'completed' => $mode['progress']['completed_count'] ?? 0,
            'total'     => $mode['progress']['total_count'] ?? 0,
        ];
    }
}
