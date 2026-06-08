<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WowInstance extends Model
{
    protected $fillable = [
        'blizzard_id',
        'name_en',
        'name_fr',
        'expansion_id',
        'expansion_name_en',
        'expansion_name_fr',
        'season',
    ];

    public function getDisplayNameAttribute(): string
    {
        return $this->name_fr ?? $this->name_en;
    }
}
