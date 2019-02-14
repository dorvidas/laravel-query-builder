<?php

namespace Dorvidas\QueryBuilder\Filters;

class EqFilter implements FilterInterface
{

    /**
     * @param mixed $query
     * @param $value
     * @param array $params
     */
    public function apply($query, $value, array $params): void
    {
        $col = $params[0];
        $query->where($col, '=', $value);
    }
}