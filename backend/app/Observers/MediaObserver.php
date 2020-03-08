<?php

namespace App\Observers;

use App\Media;
use App\Jobs\FetchMedia;

class MediaObserver
{
    public function saving(Media $media) {
    }

    public function saved(Media $media) {
        FetchMedia::dispatch($media, $media->id);
    }
}
