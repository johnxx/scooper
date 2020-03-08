<?php

namespace App\Jobs;

use App\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Requests;

class FetchMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $media;

    protected $media_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Media $media, $media_id)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET'
            ]
        ]);

        /* Sends an http request to www.example.com
           with additional headers shown above */
        $file_resource = fopen($this->media->canonical_url, 'r', false, $context);
        $file_name = collect(explode('/', $this->media->canonical_url))->last();
        Storage::put($file_name, $file_resource, 'public');
    }
}
