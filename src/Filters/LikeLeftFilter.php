<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeLeftFilter implements FilterInterface
{
    public function apply($query, $value, $params)
    {
        $col = $params[0];
        $query->where($col, 'like', '%' . $value);
    }
}