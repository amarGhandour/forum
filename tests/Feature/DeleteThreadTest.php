<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_unauthorized_users_cannot_delete_a_thread()
    {
        $thread = Thread::factory()->create();

        $this->delete(route('threads.destroy', $thread))->assertRedirect(route('login'));

        $user = User::factory()->create();

        $thread = Thread::factory()->create();

        $this->actingAs($user)
            ->delete(route('threads.destroy', $thread))
            ->assertForbidden();
    }

    public function test_an_authorized_users_can_delete_threads()
    {

        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id
        ]);

        $replies = Reply::factory()->create([
            'thread_id' => $thread->id,
        ]);

        $this->actingAs($user)
            ->delete(route('threads.destroy', $thread));

        $this->assertDatabaseMissing('threads', $thread->toArray());

        $this->assertDatabaseMissing('replies', $replies->toArray());

    }
}
