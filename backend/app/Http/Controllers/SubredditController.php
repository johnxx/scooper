<?php

namespace App\Http\Controllers;

use App\Subreddit;
use Illuminate\Http\Request;

class SubredditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Subreddit  $subreddit
     * @return \Illuminate\Http\JsonResponse
     */
    public function media(Subreddit $subreddit)
    {
        $media = collect();
        foreach($subreddit->posts as $post) {
            $post_images = $post->media->map(function($img) {
                return [
                    'src' => asset($img->file_path),
                    'width' => $img->width / 2,
                    'height' => $img->height / 2
                ];
            });
            $media = $media->concat($post_images);
            // $media->merge($post->images->map(function($img) {
            //     return [
            //         'src' => $img->file_path,
            //         'width' => $img->width,
            //         'height' => $img->height
            //     ];
            // }));
        }
        return response()->json($media);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subreddit  $subreddit
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Subreddit $subreddit)
    {
        return response()->json($subreddit->posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subreddit  $subreddit
     * @return \Illuminate\Http\Response
     */
    public function edit(Subreddit $subreddit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subreddit  $subreddit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subreddit $subreddit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subreddit  $subreddit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subreddit $subreddit)
    {
        //
    }
}
