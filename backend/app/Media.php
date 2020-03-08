<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Observers\MediaObserver;

/**
 * App\Media
 *
 * @property int $id
 * @property string|null $media_type
 * @property string|null $gallery_url
 * @property int|null $gallery_id
 * @property string $canonical_url
 * @property int $downloaded
 * @property int $download_attempts
 * @property string $file_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Media $gallery
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $galleryMedia
 * @property-read int|null $gallery_media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereCanonicalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereDownloadAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereDownloaded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereGalleryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereGalleryUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereMediaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Media extends Model
{

    protected $guarded = [];

    public static function boot() {
        parent::boot();
        self::observe(new MediaObserver);
    }

    public function gallery() {
        return $this->hasOne('App\Media')
            ->where('id', '=', $this->gallery_id);
    }

    public function galleryImages() {
        return $this->galleryMedia()
            ->where('media_type', '=', 'image');
    }

    public function galleryMedia() {
        return $this->hasMany('App\Media')
            ->where('gallery_id', '=', $this->id);
    }

    public function posts() {
        return $this->belongsToMany('App\Post', 'media_posts');
    }
}
