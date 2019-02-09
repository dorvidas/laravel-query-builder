<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeBothFilter implements FilterInterface
{
    public function apply($query, $col, $value)
    {
        $query->where($col, 'like', '%' . $value . '%');
    }
}