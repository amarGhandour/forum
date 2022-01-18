<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyStoreRequest;
use App\Models\Thread;

class RepliesController extends Controller
{

    public function store(ReplyStoreRequest $request, Thread $thread)
    {
        $thread->addReply(
            $request->validated() + ['user_id' => auth()->id()]
        );

        return redirect($thread->path())->with('Reply has been added.');
    }
}
