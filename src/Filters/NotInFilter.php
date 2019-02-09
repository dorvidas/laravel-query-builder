<?php

namespace Dorvidas\QueryBuilder\Filters;

class NotInFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->whereNotIn($col, explode(',', $value));
    }
}