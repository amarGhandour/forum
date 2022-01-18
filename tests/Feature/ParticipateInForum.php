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
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post("threads/1/replies", []);
    }
}
