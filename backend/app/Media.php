<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    public function gallery() {
        return $this->hasOne('App/Media')
            ->where('id', '=', $this->gallery_id);
    }

    public function galleryImages() {
        return $this->galleryMedia()
            ->where('media_type', '=', 'image');
    }

    public function galleryMedia() {
        return $this->hasMany('App/Media')
            ->where('gallery_id', '=', $this->id);
    }

    public function posts() {
        return $this->belongsToMany('App/Post');
    }
}
