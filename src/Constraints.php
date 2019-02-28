<?php

namespace Dorvidas\QueryBuilder;

use Dorvidas\QueryBuilder\Exceptions\IncludeNotAllowedException;

class Constraints
{
    protected $allowIncludes = [];

    public function allowIncludes($includes = []): self
    {
        $this->allowIncludes = $includes;

        return $this;
    }

    /**
     * @param $includes
     * @return bool
     * @throws IncludeNotAllowedException
     */
    public function checkIncludes($includes): bool
    {
        foreach ($includes as $include => $filters) {
            $pass = false;
            $includesArray = explode('.', $include);

            foreach ($this->allowIncludes as $allowInclude) {
                $allowIncludesArray = explode('.', $allowInclude);

                if (array_slice($allowIncludesArray, 0, count($includesArray)) == $includesArray) {
                    $pass = true;
                    break;
                }
            }
            if (!$pass) {
                throw new IncludeNotAllowedException($include);
            }
        }

        return true;
    }
}