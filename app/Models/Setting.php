<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Setting extends Model
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
