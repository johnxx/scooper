<?php

namespace App\Jobs;

use App\Post;
use App\Reddit\SubredditAPI;
use App\Subreddit;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchSubreddit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subreddit;

    public $sort;

    public $uuid = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Subreddit $subreddit, $sort, $job_uuid)
    {
        $this->subreddit = $subreddit;
        $this->sort = $sort;
        if(!empty($job_uuid))
            $this->uuid = $job_uuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $redis_cfg = config('database.redis.default');
        $client = new \Predis\Client($redis_cfg);
        $sub_api = new SubredditAPI($this->subreddit->name);
        $res = $sub_api->posts($this->sort);
        foreach($res->children as $post) {
            $post = Post::createFromRedditPost($post->data);
        }
        if($this->uuid)
            $client->publish('job.'.$this->uuid, json_encode([
                'count' => count($res->children),
                'subreddit' => $this->subreddit->name,
                'success' => 1
            ]));
        return $res;
    }
}
