<?php

namespace App\Console\Commands;

use App\Subreddit;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

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
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $sub_name = $this->argument('subreddit');
        try {
            $sub = Subreddit::where('name', $sub_name)->firstOrFail();
        } catch(\Exception $exception) {
            print("Subreddit '$sub_name' not found in the db. Add it first.");
            return false;
        }
        $job_uuid = Uuid::uuid4();
        $channel = 'job.'.$job_uuid;
        $redis_cfg = config('database.redis.default');
        $client = new \Predis\Client($redis_cfg);
        $pubsub = $client->pubSubLoop();
        $pubsub->subscribe($channel);
        \App\Jobs\FetchSubreddit::dispatch($sub, $this->option('sort'), $job_uuid);
        foreach($pubsub as $message) {
            $complete = false;
            switch($message->kind) {
                case 'message':
                    $info = json_decode($message->payload);
                    switch($info->notification) {
                        case 'post':
                            if($info->success) {
                                print("{$info->subreddit}: {$info->post}\n");
                            }
                            break;
                        case 'subreddit':
                            if($info->success) {
                                print("Saved {$info->count} posts from {$info->subreddit}\n");
                                $complete = true;
                            }
                            break;
                    }
                    break;
                default:
                    break;

            }
            if($complete)
                break;
        }
    }
}
