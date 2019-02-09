<?php

namespace Dorvidas\QueryBuilder\Filters;

class GreaterThanFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $this->query->where($col, '>', $value);
    }
}