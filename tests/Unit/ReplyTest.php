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

    public function test_reply_belongs_to_a_thread()
    {
        $reply = Reply::factory()->create();

        $this->assertInstanceOf('App\Models\Thread', $reply->thread);
    }

}
