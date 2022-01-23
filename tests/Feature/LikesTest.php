<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_an_authenticated_user_can_like_a_reply()
    {

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create([
            'thread_id' => $thread->id
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)->get($thread->path())->assertSeeText('Like');

        $this->actingAs($user)->post("/replies/$reply->id/likes");

        $this->assertCount(1, $reply->likes);
    }

    public function test_guest_can_not_like_a_reply()
    {

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create([
            'thread_id' => $thread->id
        ]);

        $this->get($thread->path())->assertDontSeeText('Like');

        $this->post("/replies/$reply->id/likes")->assertRedirect(route('login'));

        $this->assertCount(0, $reply->likes);

    }

    public function test_an_authenticated_user_can_like_a_reply_once()
    {

        $this->withoutExceptionHandling();

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create([
            'thread_id' => $thread->id
        ]);

        $user = User::factory()->create();


        $this->actingAs($user)->post("/replies/$reply->id/likes");
        $this->actingAs($user)->post("/replies/$reply->id/likes");
        $this->actingAs($user)->post("/replies/$reply->id/likes");

        $this->assertCount(1, $reply->likes);


    }
}
