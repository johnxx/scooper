<?php

namespace App;

use StdClass;
use Illuminate\Database\Eloquent\Model;
use App\ScoopModel;

/**
 * App\Subreddit
 *
 * @property int $id
 * @property string $reddit_id
 * @property string $name
 * @property string $raw_data
 * @property int $subscribed
 * @property int $poll_interval
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit wherePollInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit whereRawData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit whereRedditId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit whereSubscribed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subreddit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subreddit extends ScoopModel
{

    protected $guarded = [];

    protected $casts = [
        'raw_data' => 'array'
    ];

    public static function createFromSubreddit(StdClass $subreddit) {
        return $subreddit = self::updateOrCreate(
            [
                'reddit_id' => $subreddit->name
            ],
            [
                'name' => $subreddit->display_name,
                'raw_data' => $subreddit,
                'subscribed' => 1,
                'poll_interval' => '1h'
            ]);
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }
}
