<?php

namespace Dorvidas\QueryBuilder\Filters;

class LowerThanEqualFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->where($col, '<=', $value);
    }
}