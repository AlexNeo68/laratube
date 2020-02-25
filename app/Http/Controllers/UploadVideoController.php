<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Jobs\ConvertVideoJob;
use App\Jobs\CreateVideoThumb;
use Illuminate\Http\Request;

class UploadVideoController extends Controller
{
    public function index(Channel $channel)
    {
        $videos = $channel->videos;
        return view('channels.upload', compact('channel', 'videos'));
    }

    public function store(Request $request, Channel $channel)
    {
        $video = $channel->videos()->create([
            'title' => $request->title,
            'path' => $request->video->store("channels/{$channel->id}/videos"),
        ]);

        CreateVideoThumb::dispatch($video);
        ConvertVideoJob::dispatch($video);

        return response()->json($video, 201);
    }
}
