<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends CustomModel implements HasMedia
{
    use HasFactory,
        InteractsWithMedia;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'abbreviation',
        'short_description',
        'description',
        'logo_url',
    ];

    protected $appends = [
        'featured',
        'featured_url'
    ];

    /**
     * Get the conferences for the team.
    */
    public function conferences(){
        return $this->belongsToMany(Conference::class, 'conference_team', 'team_id', 'conference_id');
    }

    public function getFeaturedAttribute(){
        $media = null;
        if($this->hasMedia('featured')){
            $media = $this->getFirstMedia('featured');
        }
        return $media;
    }

    public function getFeaturedUrlAttribute(){
        $url = '';
        if($this->hasMedia('featured')){
            $url = $this->getFirstMedia('featured')->getUrl();
        }
        return $url;
    }

}
