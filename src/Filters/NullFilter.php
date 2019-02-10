<?php

namespace Dorvidas\QueryBuilder\Filters;

class NullFilter implements FilterInterface
{
    public function apply($query, $value, $params)
    {
        $col = $params[0];
        $query->whereNull($col);
    }
}