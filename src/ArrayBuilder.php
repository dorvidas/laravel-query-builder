<?php

namespace Dorvidas\QueryBuilder;

use Dorvidas\QueryBuilder\Exceptions\FilterNotExist;

class ArrayBuilder implements ArrayBuilderInterface
{
    protected $filters = [];
    protected $includeFilters = [];

    public function __construct()
    {
        $this->existingFilters = config('query-builder.filters');
    }

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
        foreach ($filters as $filter => $value) {
            if ($value === null) continue;
            $filterName = $this->extractFilterName($filter);
            $filterClass = $this->existingFilters[$filterName] ?? null;
            if (!$filterClass) throw new FilterNotExist($filterName);
            (new $filterClass)->apply($builder, $value, $this->extractParams($filter));
        }
    }

    private function extractParams($filterWithParams)
    {
        if (($filterNameEnds = strpos($filterWithParams, ':')) === false) {
            return [];
        }
        return explode(',', substr($filterWithParams, $filterNameEnds + 1));
    }

    private function extractFilterName($filterWithParams)
    {
        if (($filterNameEnds = strpos($filterWithParams, ':')) === false) {
            return $filterWithParams;
        } else {
            return substr($filterWithParams, 0, $filterNameEnds);
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

