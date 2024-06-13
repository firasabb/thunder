<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends CustomModel implements HasMedia
{
    use HasFactory,
        InteractsWithMedia,
        SoftDeletes;


    protected $fillable = [
        'uuid',
        'title',
        'short_description',
        'description',
        'phone',
        'email',

    ];

    /**
    * Get the contest that owns the entry.
    */
    public function contest(){
        return $this->belongsTo(Contest::class);
    }


    /**
     * 
     * Verification Code
     * 
     */
    public function verificationCode(){
        return $this->hasOne(VerificationCode::class);
    }


    /**
     * 
     * Entry Teams
     * 
     */
    public function teams(){
        return $this->hasMany(EntryTeam::class);
    }
}
