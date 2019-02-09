<?php

namespace Dorvidas\QueryBuilder\Filters;

interface FilterInterface
{
    public function apply($query, $col, $value);
}