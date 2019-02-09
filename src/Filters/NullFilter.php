<?php

namespace Dorvidas\QueryBuilder\Filters;

class NullFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        if ($value) {
            $query->whereNull($col);
        } else {
            $query->whereNotNull($col);
        }
    }
}