# RestRouter

## About

The `rest-router` package allows you to construct urls by passing in an Eloquent
model or corresponding class name.

## Features

* Smart url construction using classes and models.

## Installation

Require the `silvertipsoftware/rest-router` package in your `composer.json` and update your
dependencies:
```sh
$ composer require silvertipsoftware/rest-router
```

The package can be used by directly calling `url()` or `path()` on 
`SilvertipSoftware\RestRouter\RestRouter`, but for convenience, a mixin for Laravel's built-in 
`URL` facade is provided. To use, in your `RouteServiceProvider::boot` method, call:
```php
URL::mixin(new \SilvertipSoftware\RestRouter\UrlMixins);
```

The `url()` and `path()` methods will now be available on `URL`.

## Usage

`RestRouter` is built primarily to work on routes defined with the `Route::resource()` method of 
Laravel's router, although hand-rolled routes can also be used. Behind the scenes, `RestRouter` 
uses the route names to create urls; the actual textof the url is irrelevant. 

### Simple Resource Routes

Assume that the following resource has been defined:
```php
Route::resource('posts', 'PostsController');
```

Then in your code you can do:
```php
$post = Post::find(123);
$url = URL::url($post); 
// $url = https://mysite.com/posts/123

$path = URL::path(Post::class);
// $path = /posts
$path = URL::path(new Post);
// $path = /posts

$url = URL::url($post, 'edit');
// $url = https://mysite.com/posts/123/edit

$path = URL::path(Post::class, 'create');
// $path = /posts/create
```

### Fallbacks

Not every REST action need be defined on a resource. `RestRouter` will check other route names 
which generate the same url, since it is not concerned with the HTTP method used. For example:
```php
Route::resource('logs', 'LogsController')->only(['store', 'destroy']);


// the 'logs.index' route doesn't need to be defined:
$path = URL::path(Log::class);
// $path = /logs

// the 'logs.show' route doesn't need to be defined:
$path = URL::path($logEntry);
// $path = /logs/123
```

### Prefixed Resource Routes

`RestRouter` needs to be given any route name prefixes (*not* uri prefixes) defined. For example:
```php
Route::prefix('backoffice')->name('admin.')->group(function () {
  Route::resource('logs', 'LogsController');
});


$path = URL::path('admin', Log::class);
// $path = /backoffice/logs

$path = URL::path('backoffice', Log::class); // errors
```

### Non-REST Actions

If you've defined non-typical REST actions on your resource, you can pass an `action` option to 
`RestRouter` to find that route name. For example:
```php
Route::get('/posts/{post}/metadata', 'PostsController@metadata')->name('posts.metadata');


$path = URL::path($post, ['action' => 'metadata']);
// $path = /posts/123/metadata
```

### Nested Resources

`RestRouter` assumes shallow resources by default. If you use nested resources, this can be enabled 
globally or on a per-route basis.

For enabling nested resource support globally, in your `RouteServiceProvider` insert:
```php
RestRouter::$shallowResources = false;
```

On a per-route basis, pass a `"shallow" => false` option to your call to `url()` or `path()` as 
below. For example:
```php
Route::resource('posts.comments', 'CommentsController');


$path = URL::path($post, $comment, ['shallow' => false]);
// $path = /posts/123/comments/456
```

### Route Generation Options

If the last argument is an array, it is treated as a keyed array of options to modify the url. 
Available options are:
```php
$options = [
  'shallow' => false, // defaults to true
  'action' => 'edit', // RESTful actions 'create', 'edit' etc. or any other action you've defined
  'format' => 'json' // added as an extension to the uri, can be anything
]
```

Any other keys added to the `$options` parameter are treated as either query parameters for the 
generated url, or as route parameters if they are defined.

```php
Route::resource('posts', 'PostsController');
Route::get('/{account_id}/logs/{log}')->name('logs.show');


$path = URL::path($log, ['account_id'=>111]);
// $path = /111/logs/123

$url = URL::url($post, ['action' => 'edit']); 
// $url = https://mysite.com/posts/456/edit

$path = URL::path($post, ['format' => 'json']);
// $path = /posts/456.json

$path = URL::path($post, ['mode' => 'full']);
// $path = /posts/456?mode=full
```

Also works in blade templates:
```blade
  <a href="{{ URL::url($post) }}"</a>
```
will render to:
```html
  <a href="https://mysite.com/posts/123"</a>
```

## License

Released under the MIT License, see [LICENSE](LICENSE).