<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends CustomModel
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'abbreviation',
        'short_description',
        'description',
        'logo_url',
    ];


    /**
     * Get the teams for the conference.
     */
    public function teams(){
        return $this->belongsToMany(Team::class, 'conference_team', 'conference_id', 'team_id');
    }
}
