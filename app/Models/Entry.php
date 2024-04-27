<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends CustomModel
{
    use HasFactory;


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
