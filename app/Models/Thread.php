<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['category'], function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });

        $query->when($filters['creator'], function ($query, $creator) {
            $query->whereHas('creator', function ($query) use ($creator) {
                $query->where('name', $creator);
            });
        });
    }

}
