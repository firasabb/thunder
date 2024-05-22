<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
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
