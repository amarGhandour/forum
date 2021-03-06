<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
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

    public function test_user_can_filter_threads_according_to_categories()
    {
        $this->withoutExceptionHandling();
        $category = Category::factory()->create([
            'slug' => 'php',
        ]);

        $threadToSee = Thread::factory()->create([
            'category_id' => $category->id,
        ]);

        $threadNotToSee = Thread::factory()->create();

        $this->get('threads/php')
            ->assertSee($threadToSee->title)
            ->assertDontSee($threadNotToSee->title);
    }

    public function test_user_can_filter_threads_according_to_creators()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $threadToSee = Thread::factory()->create([
            'user_id' => $user->id
        ]);

        $threadNotToSee = Thread::factory()->create();

        $this->get("/threads?creator=$user->name")
            ->assertSee($threadToSee->title)
            ->assertDontSee($threadNotToSee->title);

    }


    public function test_user_can_filter_threads_by_popularity()
    {

        $thread = Thread::factory()->create();

        $threadWithTwoReplies = Thread::factory()->create();

        Reply::factory(2)->create([
            'thread_id' => $threadWithTwoReplies->id
        ]);

        $threadWithOneReply = Thread::factory()->create();
        Reply::factory()->create([
            'thread_id' => $threadWithOneReply->id
        ]);

        $this->get('/threads?popular=1')->assertSeeTextInOrder([
            $threadWithTwoReplies->title,
            $threadWithOneReply->title,
            $thread->title,
        ]);
    }


}
