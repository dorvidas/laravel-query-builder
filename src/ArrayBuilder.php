<?php

namespace Dorvidas\QueryBuilder;

use Dorvidas\QueryBuilder\Filters\EqFilter;
use Dorvidas\QueryBuilder\Filters\GreaterThanFilter;
use Dorvidas\QueryBuilder\Filters\InFilter;
use Dorvidas\QueryBuilder\Filters\LikeFilter;
use Dorvidas\QueryBuilder\Filters\LowerThanFilter;
use Dorvidas\QueryBuilder\Filters\NullFilter;

class ArrayBuilder implements ArrayBuilderInterface
{
    protected $filters = [];
    protected $includeFilters = [];
    protected $existingFilters = [
        'eq' => EqFilter::class,
        'in' => InFilter::class,
        'gt' => GreaterThanFilter::class,
        'lt' => LowerThanFilter::class,
        'like' => LikeFilter::class,
        'n' => NullFilter::class
    ];

    /**
     * @param array $filters
     * @return ArrayBuilderInterface
     */
    public function filters(array $filters): ArrayBuilderInterface
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param array $includes
     * @return ArrayBuilderInterface
     */
    public function includes(array $includes): ArrayBuilderInterface
    {
        $this->includeFilters = $includes;

        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder
     */
    public function build(\Illuminate\Database\Eloquent\Builder $builder): void
    {
        $includes = array_undot(collect($this->includeFilters)
            ->map(function () {
                return true;
            })->toArray());

        $this->buildRecursively($builder, $this->filters, $includes);
    }

    private function applyFilters($builder, $filters)
    {
        foreach ($filters as $filter => $cols) {
            $filterClass = $this->existingFilters[$filter] ?? null;
            if (!$filterClass) throw new \Exception('No such filter');
            foreach ($cols as $col => $value) {
                (new $filterClass)->apply($builder, $col, $value);
            }
        }
    }

    private function buildRecursively($query, $filters, $includes, $path = '')
    {
        $this->applyFilters($query, $filters);
        if (is_array($includes)) {
            foreach ($includes as $include => $deeperIncludes) {
                $query->with([
                    $include => function ($query) use ($filters, $deeperIncludes, $path, $include) {
                        $newPath = trim(".$path.$include", '.');
                        $this->buildRecursively($query,
                            $this->getIncludeFilters($newPath),
                            $deeperIncludes,
                            $newPath);
                    }
                ]);
            }
        }
    }

    protected function getIncludeFilters($include)
    {
        if (array_key_exists($include, $this->includeFilters)) {
            return $this->includeFilters[$include];
        } else {
            return [];
        }
    }
}

