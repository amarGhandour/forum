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
        $this->withoutExceptionHandling();
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

        $this->post(route('threads.store'), [])
            ->assertRedirect(route('login'));
    }

    public function test_a_thread_requires_a_title()
    {

        $this->publishThread(['body' => null])->assertSessionHasErrors();

    }

    public function test_a_thread_requires_a_body()
    {

        $this->publishThread(['body' => null])->assertSessionHasErrors();
    }

    public function test_a_thread_requires_a_category_id()
    {

        $this->publishThread(['category_id' => null])->assertSessionHasErrors();
    }

    public function test_a_category_id_must_exits_in_database()
    {

        $this->publishThread(['category_id' => 999999])->assertSessionHasErrors();
    }

    public function publishThread($attributes = [])
    {

        $thread = Thread::factory()->make($attributes);

        return $this->actingAs(User::factory()->create())->post(route('threads.store'), $thread->toArray());
    }


}
