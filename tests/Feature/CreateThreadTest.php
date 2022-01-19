<?php

namespace Tests\Feature;

use App\Models\Category;
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
        $category = Category::factory()->create();

        $thread = Thread::factory()->make(['category_id' => $category->id]);

        $this->actingAs($user)
            ->post('/threads', $thread->toArray());

        $thread = Thread::where('title', $thread->title)->first();

        $this->get($thread->path())
            ->assertSee($thread->body)
            ->assertSee($thread->title)
            ->assertSee($user->name);
    }

    public function test_guest_can_not_create_new_thread()
    {
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));

        $this->post('/threads', [])
            ->assertRedirect(route('login'));
    }

}
