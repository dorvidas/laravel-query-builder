<?php

namespace Dorvidas\QueryBuilder\Filters;

class EqFilter implements FilterInterface
{

    public function apply($query, $col, $value)
    {
        $query->where($col, '=', $value);
    }
}