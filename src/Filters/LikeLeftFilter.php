<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeLeftFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->where($col, 'like', '%' . $value);
    }
}