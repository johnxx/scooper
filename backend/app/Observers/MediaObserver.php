<?php

namespace App\Observers;

use App\Media;
use App\Jobs\FetchMedia;

class MediaObserver
{
    public function saving(Media $media) {
    }

    public function saved(Media $media) {
        if(!$media->downloaded && $media->download_attempts < 5)
            FetchMedia::dispatch($media);
    }
}
