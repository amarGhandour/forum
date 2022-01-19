<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_view_all_threads()
    {

        $thread = Thread::factory()->create();

        $this->get('/threads')
            ->assertSee($thread->title);
    }

    public function test_user_can_view_specific_thread()
    {
        $this->withoutExceptionHandling();
        $thread = Thread::factory()->create();

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }

    public function test_user_can_view_replies_that_are_associated_with_a_thread()
    {

        $this->withoutExceptionHandling();

        $thread = Thread::factory()->create();

        $reply = Reply::factory()->create([
            'thread_id' => $thread->id
        ]);

        $this->get($thread->path())
            ->assertSee($reply->body)
            ->assertSee($reply->owner->name);
    }

}
