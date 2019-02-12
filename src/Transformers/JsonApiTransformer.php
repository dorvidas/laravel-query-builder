<?php

namespace Dorvidas\QueryBuilder\Transformers;

use http\Params;

class JsonApiTransformer implements TransformerInterface
{
    protected $data;

    /**
     * JsonApiTransformer constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        $filters = [];
        if (!isset($this->data['filter'])) return $filters;

        foreach ($this->data['filter'] as $filter => $params) {
            if (strpos($filter, '.') === false) {
                $filters[$filter] = $params;
            }
        }

        return $filters;
    }

    /**
     * @return array
     */
    public function includes(): array
    {
        $includes = [];

        if (!isset($this->data['include'])) return $includes;

        $includesArray = strpos($this->data['include'], ',') ? explode(',', $this->data['include']) : [$this->data['include']];

        foreach ($includesArray as $dotIncludes) {
            $parts = explode('.', $dotIncludes);
            $include = '';
            foreach ($parts as $part) {
                $include = trim($include . '.' . $part, '.');
                if (!isset($includes[$include])) {
                    $includes[$include] = $this->getFiltersForInclude($include);
                }

            }
        }

        return $includes;
    }

    /**
     * @param $include
     * @return array
     */
    protected function getFiltersForInclude($include)
    {
        $filters = [];

        if (!isset($this->data['filter'])) return $filters;

        foreach ($this->data['filter'] as $filter => $params) {
            //Filter of include should have dot
            if (($pos = strrpos($filter, '.')) === false) {
                continue;
            }

            if (substr($filter, 0, $pos) == $include) {
                $filters[substr($filter, $pos + 1)] = $params;
            }
        }
        return $filters;

    }
}