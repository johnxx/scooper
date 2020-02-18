<?php

namespace App\Reddit;

use Requests;
use App\RedditToken;
use App\Subreddit;

class SubredditAPI {

    protected $base_url = 'https://oauth.reddit.com/r/';
    protected $token;

    public $subreddit;

    public function __construct(string $subreddit)
    {
        $this->token = RedditToken::acquire();
        $this->subreddit = $subreddit;
    }

    public function fetch(string $sort = 'hot') {
        $url = $this->base_url.$this->subreddit.'/'.$sort.".json"."?raw_json=1";
        $headers = [
            'Authorization' => 'bearer '.$this->token,
            'Accept' => 'application/json'
        ];
        $res = Requests::get($url, $headers);
        return json_decode($res->body);
    }

}
