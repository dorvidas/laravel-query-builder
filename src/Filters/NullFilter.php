<?php

namespace Dorvidas\QueryBuilder\Filters;

class NullFilter implements FilterInterface
{
    public function apply($query, $value = null, array $params): void
    {
        $col = $params[0];
        $query->whereNull($col);
    }
}