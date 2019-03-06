<?php
return [
    /*
     * Here you can define filters. These are built in filters. You are free to add your custom filters. A filter
     * basically needs to implement Dorvidas\QueryBuilder\Filters\FilterInterface
     */
    'filters' => [
        'eq' => \Dorvidas\QueryBuilder\Filters\EqFilter::class,
        'neq' => \Dorvidas\QueryBuilder\Filters\NotEqFilter::class,
        'in' => \Dorvidas\QueryBuilder\Filters\InFilter::class,
        'nin' => \Dorvidas\QueryBuilder\Filters\NotInFilter::class,
        'gt' => \Dorvidas\QueryBuilder\Filters\GreaterThanFilter::class,
        'gte' => \Dorvidas\QueryBuilder\Filters\GreaterThanEqualFilter::class,
        'lt' => \Dorvidas\QueryBuilder\Filters\LowerThanFilter::class,
        'lte' => \Dorvidas\QueryBuilder\Filters\LowerThanEqualFilter::class,
        'plike' => \Dorvidas\QueryBuilder\Filters\LikeLeftFilter::class,
        'likep' => \Dorvidas\QueryBuilder\Filters\LikeRightFilter::class,
        'plikep' => \Dorvidas\QueryBuilder\Filters\LikeBothFilter::class,
        'n' => \Dorvidas\QueryBuilder\Filters\NullFilter::class,
        'nn' => \Dorvidas\QueryBuilder\Filters\NotNullFilter::class,
    ],
];