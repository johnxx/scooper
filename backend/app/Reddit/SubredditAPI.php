<?php

namespace App\Reddit;

use Requests;
use App\RedditToken;
use App\Subreddit;

class SubredditAPI {

    protected $base_url = 'https://oauth.reddit.com/r/';
    protected $token;

    public $subreddit;

    protected $headers;

    public function __construct(string $subreddit)
    {
        $this->token = RedditToken::acquire();
        $this->subreddit = $subreddit;
        $this->headers = [
            'Authorization' => 'bearer '.$this->token,
            'Accept' => 'application/json'
        ];
    }

    protected function fetch($url) {
        return json_decode(Requests::get($url, $this->headers)->body)->data;
    }

    public function about() {
        $url = $this->base_url.$this->subreddit.'/about.json?raw_json=1';
        $res = $this->fetch($url);
        return $res;
    }

    public function posts(string $sort = 'hot') {
        $url = $this->base_url.$this->subreddit.'/'.$sort.".json"."?raw_json=1";
        $res = $this->fetch($url);
        return $res;
    }

}
