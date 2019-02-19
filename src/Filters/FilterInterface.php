<?php

namespace Dorvidas\QueryBuilder\Filters;

interface FilterInterface
{
    /**
     * @param mixed $query
     * @param $value
     * @param array $params
     */
    public function apply($query, $value = null, array $params): void;
}