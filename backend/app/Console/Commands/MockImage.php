<?php

namespace App\Console\Commands;

use App\Media;
use App\Post;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class MockImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mock:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a single mock image';

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
        $uuid4 = Uuid::uuid4();
        $img = Media::create([
            'media_type' => 'image',
            'canonical_url' => 'https://i.redd.it/8qltad43oqn41.jpg#'.$uuid4,
            'downloaded' => 1,
            'download_attempts' => 1,
            'file_path' => 'storage/8qltad43oqn41.jpg',
            'width' => 555,
            'height' => 1475,
        ]);
        $post = Post::find(1);
        $post->media()->attach($img);
    }
}
