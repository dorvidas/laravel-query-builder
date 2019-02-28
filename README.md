# Easily build Eloquent queries from API requests

This package allows you to filter and include eloquent relations based on a request. Filtering is possible even on relations. Query parameter names follow the [JSON API specification](https://jsonapi.org/) as closely as possible.

## Basic usage

Filtering an API request by checking if column equals to value: `/users?filter[eq:active]=1` or `/users?filter[active]=1`(if no filter defined, the default `eq` filter is used):

```php
$users = User::buildFromRequest()
    ->get();
// all `User`s that with columns `active` equal to 1
```

Requesting filtered relations from an API request: `/users?filter[posts.eq:published]=1&include=posts`:

```php
$users = User::buildFromRequest()
    ->get();
// all `User`s with their published `posts` loaded
```

Requesting deep relations filtered from an API request: `/users?filter[posts.comments.eq:approved=1&include=posts.comments`:

```php
$users = User::buildFromRequest()
    ->get();
// all `User`s with their `posts` and post `comments` that are approved
```

Works together nicely with existing queries, because `buildFromRequest` is basically Eloquent macro: `/users?filter[eq:name]=John`:

```php
$users = User::buildFromRequest()
    ->where('active', 1)
    ->get();
// all `User`s whose name is `John` also enforcing them to be active users
```

## Installation

You can install the package via composer:

```bash
composer require dorvidas/laravel-query-builder
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Dorvidas\QueryBuilder\QueryBuilderServiceProvider" --tag="config"
```


## Usage

### Filters

#### Out-of-box filters

There are number of out-of-box filters that can be used right away. Filters are listed in config:
```php
    'filters' => [
        'eq' => \Dorvidas\QueryBuilder\Filters\EqFilter::class,//Equals
        'neq' => \Dorvidas\QueryBuilder\Filters\NotEqFilter::class,//Not equals
        'in' => \Dorvidas\QueryBuilder\Filters\InFilter::class,// In 
        'nin' => \Dorvidas\QueryBuilder\Filters\NotInFilter::class, //Not in
        'gt' => \Dorvidas\QueryBuilder\Filters\GreaterThanFilter::class,//Greater than
        'gte' => \Dorvidas\QueryBuilder\Filters\GreaterThanEqualFilter::class,//Greater than equals
        'lt' => \Dorvidas\QueryBuilder\Filters\LowerThanFilter::class,//Less than
        'lte' => \Dorvidas\QueryBuilder\Filters\LowerThanEqualFilter::class,//Less that equals
        'like' => \Dorvidas\QueryBuilder\Filters\LikeFilter::class,//Like
        'nlike' => \Dorvidas\QueryBuilder\Filters\NotLikeFilter::class,//Not like
        'n' => \Dorvidas\QueryBuilder\Filters\NullFilter::class,//Null
        'nn' => \Dorvidas\QueryBuilder\Filters\NotNullFilter::class,//Not null
    ],

```

#### Using filters in URL
JSON:API is agnostic to filtering strategy. The only requirement that filter would be placed in  `&filter` query param. Proposed filter format:
* `&filter[eq:id]=1` - Column `id` equals 1. The part after semicolon is called filter attributes. Can have multiple if filter requires `&filter[between:from,to]=2018,2019`. 
* `&filter[posts.eq:id]=1` - define filter for relation `posts`. If relation is deep we define full path to it `posts.comments.eq:id=1`.

#### Create filters
If you need to create custom filter append the config. 
```php
'filters' => [
     /* ... */
    'recent' => \App\Filters\RecentFilter::class,
```

Filter should implement `
Dorvidas\QueryBuilder\FiltersFilterInterface` interface. Example filter:
```php
use Carbon\Carbon;
use Dorvidas\QueryBuilder\Filters\FilterInterface;

class RecentFilter implements FilterInterface
{
    public function apply($query, $value, $params)
    {
        $col = isset($params[0]) ? $params[0] : 'created_at';
        $query->where($col, '>', Carbon::now()->subDay($value)->toDateTimeString());
    }
}
```

#### GOTCHAs
Filters with no values are not applied i.e `$filter[eq:id]=`. Laravel application converts empty query params to `null` values by using `\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class` middleware and to filter rows where columns is `null` use `n:your_col=1` filter. Reason for that is when using documentation tools like Swagger I list all possible filters for endpoint and when value is not present I want to skip it.

### Including relations
JSON:API allows request for [related resources](https://jsonapi.org/format/#fetching-includes). This is done via `include` query param i.e. `/users?include=posts`:

```php
$users = User::buildFromRequest()
    ->get();
// all `User`s with their `posts`
// User model needs to have relation `posts`
```

#### Include constraints
It is possible to add constraints on which includes are allowed. Without it you can request for everything as long as there are requested relation defined i.e. `/users?include=posts`:
```php
//This is fine
$users = User::buildFromRequest((new Constraints())->allowIncludes(['posts']))
    ->get();
    
//This is also fine
$users = User::buildFromRequest((new Constraints())->allowIncludes(['posts.comments']))
    ->get();

// This will throw `IncludeNotAllowedException` exception because no relations allowed
$users = User::buildFromRequest((new Constraints())->allowIncludes([]))
    ->get();
```

### Manually building query
It is also possible to build query manually by using `buildFromArray` macro and passing instance of `\Dorvidas\QueryBuilder\ArrayBuilder` to it:
```php
$items = App\User::buildFromArray(
    (new \Dorvidas\QueryBuilder\ArrayBuilder)
        ->filters([
            'in:id' => [1, 2]
        ])
        ->includes([
            'posts' => ['eq:active' => 1],
            'posts.owner' => [], //no filters
            'posts.comments' => ['eq:approved' => 1],
            'posts.comments.owner' => [],
        ])
    )->get();
```
### Sparse fields - TODO

### Sorting - TODO

### Paginating - TODO

### Limit results - TODO

### Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.