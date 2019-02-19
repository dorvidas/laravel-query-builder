<?php

namespace Dorvidas\QueryBuilder\Filters;

class NotNullFilter implements FilterInterface
{
    public function apply($query, $value = null, array $params): void
    {
        $col = $params[0];
        $query->whereNotNull($col);
    }
}