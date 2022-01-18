<?php

namespace Tests\Unit;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use  RefreshDatabase, WithFaker;

    public function test_replay_has_an_owner()
    {

        $reply = Reply::factory()->create();

        $this->assertInstanceOf('App\Models\User', $reply->owner);
    }

}
