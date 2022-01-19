<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_thread_has_replies()
    {

        $thread = Thread::factory()->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    public function test_thread_has_creator()
    {
        $thread = Thread::factory()->create();

        $this->assertInstanceOf('App\Models\User', $thread->creator);
    }

    public function test_a_thread_may_add_a_reply()
    {
        $thread = Thread::factory()->create();

        $reply = Reply::factory()->make();

        $thread->addReply($reply->toArray());

        self::assertEquals(1, $thread->replies->count());
    }

    public function test_thread_belongs_to_a_category()
    {

        $category = Category::factory()->create();

        $thread = Thread::factory()->create([
            'category_id' => $category->id
        ]);


        $this->assertInstanceOf('App\Models\Category', $thread->category);

    }

    public function test_a_thread_can_return_a_string_path()
    {

        $category = Category::factory()->create();
        $thread = Thread::factory()->create([
            'category_id' => $category->id
        ]);

        $this->assertEquals("/threads/$category->slug/$thread->id", $thread->path());
    }
}
