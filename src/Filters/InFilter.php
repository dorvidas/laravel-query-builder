<?php

namespace Dorvidas\QueryBuilder\Filters;

class InFilter implements FilterInterface
{

    public function apply($query, $value, $params)
    {
        $col = $params[0];
        $query->whereIn($col, is_array($value) ? $value : explode(',', $value));
    }
}