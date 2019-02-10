<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeFilter implements FilterInterface
{
    public function apply($query, $value, $params)
    {
        $col = $params[0];
        $query->where($col, 'like', $value);
    }
}