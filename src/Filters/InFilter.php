<?php

namespace Dorvidas\QueryBuilder\Filters;

class InFilter implements FilterInterface
{

    public function apply($query, $value, array $params): void
    {
        $col = $params[0];
        $query->whereIn($col, is_array($value) ? $value : explode(',', $value));
    }
}