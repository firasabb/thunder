<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Entry extends CustomModel implements HasMedia
{
    use HasFactory,
        InteractsWithMedia;


    protected $fillable = [
        'uuid',
        'title',
        'short_description',
        'description',
    ];

    /**
    * Get the contest that owns the entry.
    */
    public function contest(){
        return $this->belongsTo(Contest::class);
    }
}
