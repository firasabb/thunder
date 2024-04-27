<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends CustomModel
{
    use HasFactory;


    protected $fillable = [
        'uuid',
        'title',
        'short_description',
        'description',
    ];


    /**
    * Get the entries for the contest.
    */
    public function entries(){
        return $this->hasMany(Entry::class);
    }
    
}
