<?php

namespace App\Http\Controllers;

use App\Models\Reply;

class LikesController extends Controller
{

    public function store(Reply $reply)
    {

        $reply->like();

        return back();
    }


}
