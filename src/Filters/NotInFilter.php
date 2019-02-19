<?php

namespace Dorvidas\QueryBuilder\Filters;

class NotInFilter implements FilterInterface
{
    public function apply($query, $value = null, array $params): void
    {
        $col = $params[0];
        $query->whereNotIn($col, is_array($value) ? $value : explode(',', $value));
    }
}