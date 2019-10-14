<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function subreddit() {
        return $this->belongsTo('App/Subreddit');
    }

    public function images() {
        return $this->media()
            ->where('media_type', '=', 'image');
    }

    public function media() {
        return $this->belongsToMany('App/Media');
    }
}
