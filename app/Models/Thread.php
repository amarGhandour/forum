<?php

namespace App\Models;

use App\Filters\ThreadsFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['replies', 'category'];

    public function path()
    {

        return "/threads/{$this->category->slug}/$this->id";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query, ThreadsFilter $filters)
    {

        return $filters->apply($query);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($query) {
            $query->withCount('replies');
        });
    }

}
