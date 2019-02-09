<?php

namespace Dorvidas\QueryBuilder;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Database\Eloquent\Builder;


class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('buildFromArray', function (ArrayBuilder $builder) {
            $builder->build($this);
            return $this;
        });
        Builder::macro('buildFromRequest', function () {
            $transformer = (new \Dorvidas\QueryBuilder\Transformers\JsonApiTransformer(request()->input()));
            (new \Dorvidas\QueryBuilder\ArrayBuilder)
                ->filters($transformer->filters())
                ->includes($transformer->includes())
                ->build($this);
            return $this;
        });
    }
}

