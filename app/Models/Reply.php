<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['owner', 'likes'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'liked');
    }

    public function like(): void
    {
        if (!$this->likes()->where('user_id', auth()->id())->exists()) {
            $this->likes()->create([
                'user_id' => auth()->id()
            ]);
        }
    }

    public function isLiked()
    {
        return !!$this->likes->where('user_id', auth()->id())->count();
    }

}
