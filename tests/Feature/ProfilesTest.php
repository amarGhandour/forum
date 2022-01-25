<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_user_has_profile()
    {
        $user = User::factory()->create();

        $thread = Thread::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->get($user->path())
            ->assertSeeText([
                $user->name,
                $thread->title,
                $thread->body
            ]);
    }


}
