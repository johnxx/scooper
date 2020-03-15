<?php

namespace App\Console\Commands;

use App\Reddit\SubredditAPI;
use App\Subreddit;
use Illuminate\Console\Command;

class AddSubreddit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subreddit:add {subreddit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add subreddit to db';

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
        $res = $sub->about();
        return Subreddit::createFromSubreddit($res);
    }
}
