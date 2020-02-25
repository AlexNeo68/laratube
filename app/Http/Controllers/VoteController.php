<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote($entityId, $type)
    {
        $entity = $this->getEntity($entityId);
        return auth()->user()->toggleVote($entity, $type);
    }

    protected function getEntity($entityId)
    {
        $entity = Video::find($entityId);

        if ($entity) return $entity;

        $entity = Comment::find($entityId);
        if ($entity) return $entity;

        throw new ModelNotFoundException('Entity not found.');
    }
}
