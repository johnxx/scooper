<?php

namespace App\Http\Controllers;

use App\Media;
use App\Subreddit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $images = Media::where('media_type', '=', 'image')->get();
        $react_gallery = $this->_asReactGallery($images);
        return response()->json($react_gallery);
    }

    /**
     * Display a listing of the resource, by subreddit
     *
     * @param Subreddit $subreddit
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexBySubreddit(Subreddit $subreddit)
    {
        $subreddit_images = Media::where('media_type', '=', 'image')
            ->whereHas('posts', function(Builder $query) use($subreddit) {
                $query->where('subreddit_id', $subreddit->id);
            })->get();
        $react_gallery = $this->_asReactGallery($subreddit_images);
        return response()->json($react_gallery);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
    }

    /**
     * @param Collection $images
     * @param float $scale
     * @return Collection|\Illuminate\Support\Collection
     */
    protected function _asReactGallery(Collection $images, $scale = 0.5) {
        return $images->map(function($img) use($scale) {
            return [
                'src' => asset($img->file_path),
                'width' => $img->width * $scale,
                'height' => $img->height * $scale
            ];
        });
    }

}
