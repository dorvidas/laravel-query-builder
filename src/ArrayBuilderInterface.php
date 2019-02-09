<?php

namespace Dorvidas\QueryBuilder;

interface ArrayBuilderInterface
{
    public function filters(array $filters): self;

    public function includes(array $includes): self;

    public function build(\Illuminate\Database\Eloquent\Builder $builder): void;
}