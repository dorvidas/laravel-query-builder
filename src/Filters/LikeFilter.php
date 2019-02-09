<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->where($col, 'like', $value);
    }
}