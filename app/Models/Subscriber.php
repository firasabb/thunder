<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends CustomModel
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_subscribed',
        'token',
    ];
}
