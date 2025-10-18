<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    protected $table = 'gallery';

    protected $fillable = ['images', 'description', 'location'];

    protected $casts = [
        'images' => 'array',
    ];

    // Accessor to get the first image (for single image display)
    public function getImageAttribute()
    {
        if (!empty($this->images) && is_array($this->images)) {
            return $this->images[0];
        }
        return null;
    }

    // Accessor to get full image URLs
    public function getImageUrlsAttribute()
    {
        if (!$this->images || !is_array($this->images)) {
            return [];
        }

        return array_map(function($image) {
            return asset('storage/' . $image);
        }, $this->images);
    }

    // Get first image URL for thumbnails
    public function getFirstImageUrlAttribute()
    {
        if (!empty($this->images) && is_array($this->images)) {
            return asset('storage/' . $this->images[0]);
        }
        return null;
    }
}
