<?php

namespace Dorvidas\QueryBuilder;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/query-builder.php' => config_path('query-builder.php'),
            ], 'config');
        }
        $this->mergeConfigFrom(__DIR__ . '/../config/query-builder.php', 'query-builder');

        Builder::macro('buildFromArray', function (ArrayBuilder $builder) {
            $builder->build($this);

            return $this;
        });
        Builder::macro('buildFromRequest', function (Constraints $constraints = null) {
            $transformer = (new \Dorvidas\QueryBuilder\Transformers\JsonApiTransformer(request()->input()));

            $filters = $transformer->filters();
            $includes = $transformer->includes();

            if ($constraints) {
                $constraints->checkIncludes($includes);
            }

            (new \Dorvidas\QueryBuilder\ArrayBuilder)
                ->filters($filters)
                ->includes($includes)
                ->build($this);

            return $this;
        });
    }
}

