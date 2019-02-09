<?php

namespace Dorvidas\QueryBuilder\Filters;

class NotEqualFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->where($col, '!=', $value);
    }
}