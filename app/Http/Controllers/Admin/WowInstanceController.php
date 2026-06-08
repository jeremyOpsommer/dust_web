<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WowInstance;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WowInstanceController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/WowInstances/Index', [
            'instances' => WowInstance::orderBy('expansion_id', 'desc')->orderBy('name_en')->get()
                ->map(fn($i) => [
                    'id'                => $i->id,
                    'blizzard_id'       => $i->blizzard_id,
                    'name_en'           => $i->name_en,
                    'name_fr'           => $i->name_fr,
                    'expansion_id'      => $i->expansion_id,
                    'expansion_name_en' => $i->expansion_name_en,
                    'expansion_name_fr' => $i->expansion_name_fr,
                    'season'            => $i->season,
                ]),
        ]);
    }

    public function update(Request $request, WowInstance $wowInstance)
    {
        $validated = $request->validate([
            'name_fr' => ['nullable', 'string', 'max:255'],
        ]);

        $wowInstance->update($validated);

        return back()->with('success', 'Instance mise à jour.');
    }

    public function updateExpansion(Request $request)
    {
        $validated = $request->validate([
            'expansion_id'      => ['required', 'integer'],
            'expansion_name_fr' => ['nullable', 'string', 'max:255'],
            'season'            => ['nullable', 'string', 'max:255'],
        ]);

        WowInstance::where('expansion_id', $validated['expansion_id'])
            ->update([
                'expansion_name_fr' => $validated['expansion_name_fr'],
                'season'            => $validated['season'],
            ]);

        return back()->with('success', 'Extension mise à jour.');
    }
}
