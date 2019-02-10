<?php

namespace Dorvidas\QueryBuilder\Filters;

class GreaterThanFilter implements FilterInterface
{
    public function apply($query, $value, $params)
    {
        $col = $params[0];
        $this->query->where($col, '>', $value);
    }
}