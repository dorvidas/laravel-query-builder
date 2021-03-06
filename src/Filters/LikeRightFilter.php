<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeRightFilter implements FilterInterface
{
    public function apply($query, $value = null, array $params): void
    {
        $col = $params[0];
        $query->where($col, 'like', $value . '%');
    }
}