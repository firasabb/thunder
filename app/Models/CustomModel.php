<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'uuid' => 'string'
    ];


    /**
     * 
     * Add the uuid when creating a new object
     * 
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
