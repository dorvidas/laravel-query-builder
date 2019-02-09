<?php

namespace Dorvidas\QueryBuilder\Filters;

class GreaterThanEqualFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->where($col, '>=', $value);
    }
}