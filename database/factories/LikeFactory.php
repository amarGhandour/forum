<?php

namespace Database\Factories;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'likable_id' => Reply::factory(),
            'liked_type' => get_class(Reply::class),
        ];
    }
}
