<?php

namespace Dorvidas\QueryBuilder\Filters;

class NotInFilter implements FilterInterface
{
    public function apply($query, $value, $params)
    {
        $col = $params[0];
        $query->whereNotIn($col, explode(',', $value));
    }
}