<?php

namespace App\Filters;

class ThreadsFilter extends Filters
{
    protected $filters = ['creator', 'popular'];

    public function creator($query, $creator)
    {
        $query->whereHas('creator', function ($query) use ($creator) {
            $query->where('name', $creator);
        });
    }

    public function popular($query)
    {
        $query->reorder('replies_count', 'desc');
    }

}
