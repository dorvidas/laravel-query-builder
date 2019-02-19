<?php

namespace Dorvidas\QueryBuilder\Filters;

class LowerThanFilter implements FilterInterface
{
    public function apply($query, $value = null, array $params): void
    {
        $col = $params[0];
        $query->where($col, '<', $value);
    }
}