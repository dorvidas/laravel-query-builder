<?php

namespace Dorvidas\QueryBuilder\Filters;

class LikeBothFilter implements FilterInterface
{
    public function apply($query, $value = null, array $params): void
    {
        $col = $params[0];
        $query->where($col, 'like', '%' . $value . '%');
    }
}