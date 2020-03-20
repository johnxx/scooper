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
     * @param Media $media
     */
    public function __construct(Media $media)
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
        $media = $this->media;
        $file_name = collect(explode('/', $media->canonical_url))->last();
        $file_ext = collect(explode('.', $file_name))->last();
        if(collect(['png', 'jpg', 'gif'])->contains($file_ext)) {
            $response = Requests::get($media->canonical_url);
            $media->download_attempts++;
            if($response->status_code == 200
                && substr($response->headers['content-type'], 0,5) === 'image') {
                $media->media_type = 'image';
                Storage::disk('public')->put($file_name, $response->body);
                $media->file_path = "storage/{$file_name}";
                list($media->width, $media->height) = getimagesizefromstring($response->body);
                $media->downloaded = true;
            }
            $media->save();
        }
    }
}
