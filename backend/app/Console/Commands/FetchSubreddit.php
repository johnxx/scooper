<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchSubreddit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:subreddit';

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
        //
    }
}
