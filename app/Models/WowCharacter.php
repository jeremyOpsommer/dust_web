<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WowCharacter extends Model
{
    protected $fillable = [
        'user_id',
        'blizzard_id',
        'name',
        'realm_slug',
        'realm_name',
        'class_name',
        'level',
        'region',
        'stats',
        'equipment',
        'pve_progression',
        'last_refreshed_at',
    ];

    protected $casts = [
        'stats'            => 'array',
        'equipment'        => 'array',
        'pve_progression'  => 'array',
        'last_refreshed_at' => 'datetime',
    ];

    public function canRefresh(): bool
    {
        return $this->last_refreshed_at === null
            || $this->last_refreshed_at->diffInMinutes(now()) >= 60;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrl(): string
    {
        return "https://render.worldofwarcraft.com/{$this->region}/character/{$this->realm_slug}/"
            . ($this->blizzard_id % 256) . "/{$this->blizzard_id}-avatar.jpg";
    }
}
