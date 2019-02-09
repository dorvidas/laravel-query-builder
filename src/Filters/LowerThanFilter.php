<?php

namespace Dorvidas\QueryBuilder\Filters;

class LowerThanFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->where($col, '<', $value);
    }
}