<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EntryTeam extends CustomModel implements HasMedia
{
    use HasFactory,
        InteractsWithMedia;


    protected $fillable = [
        'entry_id',
        'team_id',
        'conference',
    ];

    protected $table = 'entry_team';

    /**
     * Get the entry that owns the team.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry(){
        return $this->belongsTo(Entry::class);
    }


    /**
     * Get the team that owns the entry.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(){
        return $this->belongsTo(Team::class);
    }
}
