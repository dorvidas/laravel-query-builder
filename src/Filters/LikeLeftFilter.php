<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeLeftFilter implements FilterInterface
{
    public function apply($query, $value = null, array $params): void
    {
        $col = $params[0];
        $query->where($col, 'like', '%' . $value);
    }
}