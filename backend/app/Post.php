<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Object_;
use \StdClass;

/**
 * App\Post
 *
 * @property int $id
 * @property string $reddit_id
 * @property string $title
 * @property string $permalink
 * @property string $raw_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Subreddit $subreddit
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePermalink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereRawData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereRedditId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{

    protected $guarded = [];

    public static function fromRedditPost(StdClass $reddit_post) {
        $data = [
            'reddit_id' => $reddit_post->name,
            'title' => $reddit_post->title,
            'permalink' => $reddit_post->permalink,
            'raw_data' => json_encode($reddit_post)
        ];
        $post = new self;
        $post->fill($data);
        return $post;
    }

    public function subreddit() {
        return $this->belongsTo('App\Subreddit');
    }

    public function images() {
        return $this->media()
            ->where('media_type', '=', 'image');
    }

    public function media() {
        return $this->belongsToMany('App\Media');
    }
}
