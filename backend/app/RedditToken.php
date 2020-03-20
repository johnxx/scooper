<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reddit\RedditAPI;
use Carbon\Carbon;

/**
 * App\RedditToken
 *
 * @property int $id
 * @property string $username
 * @property string $access_token
 * @property string $token_type
 * @property string $expires_in
 * @property string $scope
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereTokenType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RedditToken whereUsername($value)
 * @mixin \Eloquent
 */
class RedditToken extends Model
{

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $username = isset($this->username) ? $this->username : env('X_REDDIT_USERNAME');
        if($username) {
            $this->fill(RedditAPI::getToken($this->username));
        }
    }

    public static function acquire(string $username = null) {
        $username = $username ? $username : env('X_REDDIT_USERNAME');
        $token = self::where('username', '=', $username)
            ->firstOrCreate([
                'username' => $username,
            ]);
        $last_updated = new Carbon($token->updated_at);
        if($last_updated->addSeconds($token->expires_in) >= Carbon::now()) {
            return $token;
        } else {
            $token->fill(RedditAPI::getToken($username))->save();
            return $token;
        }
    }
}
