<?php

namespace Quetab\QuetabPanel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Quetab\QuetabPanel\Models\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class SupportMessage extends CustomModel
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'title',
        'subject',
        'email',
        'phone',
        'body'
    ];
}
