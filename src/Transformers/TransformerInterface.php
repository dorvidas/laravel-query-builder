<?php

namespace Dorvidas\QueryBuilder\Transformers;

interface TransformerInterface
{
    public function __construct(array $data);

    public function filters(): array;

    public function includes(): array;
}