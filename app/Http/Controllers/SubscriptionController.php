<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Channel $channel)
    {
        return auth()->user()->subscriptions()->create(['channel_id' => $channel->id]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel, Subscription $subscription)
    {
        $subscription->delete();
        return response()->json(['success' => true], 203);
    }
}
