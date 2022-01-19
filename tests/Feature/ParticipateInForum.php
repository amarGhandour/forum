<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForum extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make();

        $this->actingAs(User::factory()->create())
            ->post($thread->path() . "/replies", $reply->toArray())
            ->assertRedirect($thread->path());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    public function test_an_unauthenticated_user_may_not_participate_in_forum_threads()
    {
        $this->post("threads/some_category/1/replies", [])
            ->assertRedirect(route('login'));
    }

    public function test_a_reply_requires_a_body()
    {

        $reply = Reply::factory()->make([
            'body' => null
        ]);

        $this->actingAs(User::factory()->create())
            ->post("{$reply->thread->path()}/replies", $reply->toArray())
            ->assertSessionHasErrors();
    }
}
