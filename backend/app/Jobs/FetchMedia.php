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
        $file_name = collect(explode('/', $this->media->canonical_url))->last();
        $file_ext = collect(explode('.', $file_name))->last();
        if(collect(['png', 'jpg', 'gif'])->contains($file_ext)) {
            $response = Requests::get($this->media->canonical_url);
            $this->media->download_attempts++;
            if($response->status_code == 200
                && substr($response->headers['content-type'], 0,5) === 'image') {
                Storage::put($file_name, $response->body, 'public');
                $this->media->downloaded = true;
            }
            $this->media->save();
        }
    }
}
