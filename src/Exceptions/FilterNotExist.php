<?php

namespace Dorvidas\QueryBuilder\Exceptions;

class FilterNotExist extends \Exception
{
    public function __construct($filter)
    {
        $message = "Filter `{$filter}` is not defined.";
        parent::__construct($message);
    }
}