<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_an_authenticated_user_can_create_new_thread()
    {

        $user = User::factory()->create();
        $thread = Thread::factory()->make();

        $this->actingAs($user)
            ->post('/threads', $thread->toArray())
            ->assertRedirect("/threads/1");

        $this->get("/threads/1")
            ->assertSee($thread->body)
            ->assertSee($thread->title)
            ->assertSee($user->name);
    }

    public function test_guest_can_not_create_new_thread()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads', [])
            ->assertRedirect(route('login'));
    }

    public function test_guest_can_not_view_create_thread_page()
    {

        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }
}
