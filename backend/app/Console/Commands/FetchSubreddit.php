<?php

namespace App\Console\Commands;

use App\Reddit\SubredditAPI;
use App\Post;
use Illuminate\Console\Command;

class FetchSubreddit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subreddit:fetch {--sort=} {subreddit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch posts from a subreddit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sub = new SubredditAPI($this->argument('subreddit'));
        $res = $sub->posts($this->option('sort'));
        foreach($res->children as $post) {
            $post = Post::createFromRedditPost($post->data);
        }
        return $res;
    }
}
