<?php

namespace Quetab\QuetabPanel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Quetab\QuetabPanel\Models\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;


class Setting extends CustomModel
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'value'
    ];

    /**
     * Get the settingable model.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function settingable(){
        return $this->morphTo();
    }
}
