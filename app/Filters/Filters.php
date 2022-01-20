<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{

    protected $request;
    protected $query;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {

        $this->query = $query;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($query, $value);
            }
        }

        return $this->query;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->request->only($this->filters);
    }
}
