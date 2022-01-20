<?php

namespace App\Filters;

class ThreadsFilter extends Filters
{
    protected $filters = ['creator'];

    public function creator($query, $creator)
    {
        $query->whereHas('creator', function ($query) use ($creator) {
            $query->where('name', $creator);
        });
    }

}
