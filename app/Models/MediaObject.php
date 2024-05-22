<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaObject extends CustomModel implements HasMedia
{

    use HasFactory,
        InteractsWithMedia,
        SoftDeletes;

    protected $fillable = [
        'filename',
        'url',
        'mime_type',
        'size',
        'title',
        'description',
        'alt_text',
        'path',
        'thumbnail_url',
        'caption',
        'credit',
        'type',
        'status',
    ];

    protected $appends = [
        'is_image'
    ];

    /**
     * Get all of the owning mediable models.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function mediable(){
        return $this->morphTo('mediable');
    }


    // Check if the media file is an image
    public function isImage(){
        $mimeType = $this->mime_type;
        return strpos($mimeType, 'image') !== false;
    }

    public function getIsImageAttribute(){
        return $this->isImage();
    }

}