<?php

namespace Dorvidas\QueryBuilder\Filters;

class InFilter
{

    public function apply($query, $col, $value)
    {
        $query->whereIn($col, is_array($value) ? $value : explode(',', $value));
    }
}