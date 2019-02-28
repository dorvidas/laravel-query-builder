<?php

namespace Dorvidas\QueryBuilder\Exceptions;

class IncludeNotAllowedException extends \Exception
{
    public function __construct($include)
    {
        $message = "Include `{$include}` is not defined.";
        parent::__construct($message);
    }
}