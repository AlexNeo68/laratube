<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateVideoRequest;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        if (request()->wantsJson()) {
            return $video;
        }

        return view('videos.show', compact('video'));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {

        $video->update($request->only([
            'title',
            'description'
        ]));

        return redirect()->back();
    }

    public function views(Video $video)
    {
        $video->increment('views');
        return $video;
    }
}
