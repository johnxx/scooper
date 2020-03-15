<?php

namespace App\Reddit;

use phpDocumentor\Reflection\Types\Nullable;
use Requests;
use App\RedditToken;
use App\Subreddit;

class SubredditAPI {

    protected $base_url = 'https://oauth.reddit.com/r/';
    protected $token;

    public $subreddit;

    public $subreddit_url;

    protected $headers;

    public function __construct(string $subreddit)
    {
        $this->token = RedditToken::acquire();
        $this->subreddit = $subreddit;
        $this->subreddit_url = $this->base_url.$subreddit;
        $this->headers = [
            'Authorization' => 'bearer '.$this->token,
            'Accept' => 'application/json'
        ];
    }

    protected function fetch($rel_url) {
        return json_decode(
            Requests::get($this->subreddit_url.$rel_url.".json?raw_json=1", $this->headers)->body
        )->data;
    }

    public function about() {
        return $this->fetch('/about');
    }

    public function posts($sort = 'hot') {
        if(empty($sort))
            $sort = 'hot';
        return $this->fetch("/$sort");
    }

}
