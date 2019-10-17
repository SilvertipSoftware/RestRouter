# RestRouter

## About

The `rest-router` package allows you to construct urls by passing in an Eloquent
model or corresponding class name.

## Features

* Smart url construction using classes and models.

## Installation

Require the `silvertipsoftware/rest-router` package in your `composer.json` and update your dependencies:
```sh
$ composer require silvertipsoftware/rest-router
```

## Usage

```php
  $myModel = \App\Models\MyModel::find(123);
  $url = \URL::url($myModel); 
  // $url = https://mysite.com/my-models/123
```
You can pass in multiple models, classes or strings to build the urls:

```php
  $myModel = \App\Models\MyModel::find(456);
  $url = \URL::url('some-prefix', '\App\Model\User', $myModel); 
  // $url = https://mysite.com/some-prefix/users/my-models/456
```

You can add `$options` to the arguments list to modify the url. Available
options are:
```
$options = [
  'shallow' => false, // defaults to true
  'action' => 'edit', // RESTful actions 'create', 'edit' etc.
  'format' => //todo
]
```

```php
  $options = ['action' => 'edit']
  $url = \URL::url($myModel, $options); 
  // $url = https://mysite.com/my-models/456/edit
```

```
// TODO more examples for shallow and format
```

Also works in blade templates:
```blade
  <a href="{{ URL::url($myModel) }}"</a>
```
will render to:
```html
  <a href="https://mysite.com/my-models/123"</a>
```

## License

Released under the MIT License, see [LICENSE](LICENSE).