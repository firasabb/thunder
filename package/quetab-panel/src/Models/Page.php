<?php

namespace Quetab\QuetabPanel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Quetab\QuetabPanel\Models\CustomModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends CustomModel implements HasMedia
{
    use HasFactory,
        SoftDeletes,
        InteractsWithMedia;

    protected $appends = [
        'featured'
    ];

    const STATUSES = [
        'draft',
        'published',
        'archived'
    ];
    
    /**
     * 
     * Get the page's featured image
     * 
     */
    public function getFeaturedAttribute(){
        $media = null;
        if($this->hasMedia('featured')){
            $media = $this->getFirstMedia('featured');
        }
        return $media;
    }
}
