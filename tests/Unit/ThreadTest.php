<?php

namespace Tests\Unit;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_thread_has_replies()
    {

        $thread = Thread::factory()->create(['title' => 'this is title']);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }
}
