<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GalleryImageTranslation extends Model
{
    protected $fillable = ['lang_id', 'gallery_image_id', 'alt', 'title', 'text'];

    protected $table = 'gallery_images_translation';

    public function gallery() {

        return $this->belongsTo(GalleryImage::class);
    }
}
