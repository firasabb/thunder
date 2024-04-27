<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends CustomModel
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'title',
        'short_description',
        'description',
    ];

    /**
     * Get the conferences for the team.
    */
    public function conferences(){
        return $this->belongsToMany(Conference::class, 'conference_teams', 'team_id', 'conference_id');
    }

}
