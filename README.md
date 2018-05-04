# Grid data
[![Latest Stable Version](https://poser.pugx.org/markard/grid-data/v/stable.svg)](https://packagist.org/packages/markard/grid-data) 
[![Total Downloads](https://poser.pugx.org/markard/grid-data/downloads.svg)](https://packagist.org/packages/markard/grid-data) [![Latest Unstable Version](https://poser.pugx.org/markard/grid-data/v/unstable.svg)](https://packagist.org/packages/markard/grid-data) 
[![License](https://poser.pugx.org/markard/grid-data/license.svg)](https://packagist.org/packages/markard/grid-data)

It's the package for Laravel 4. The package prepares data for client side tables. Plus it handles all special input data from different client side libraries and provides common API.

Currently supported: [Datatables]

[Datatables]: http://datatables.net/

## Quick start

### Required setup

In the `require` key of `composer.json` file add the following

    "markard/grid-data": "0.*"

Run the Composer update comand

    $ composer update

In your `config/app.php` add `'Markard\GridData\GridDataServiceProvider'` to the end of the `providers` array

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'Markard\GridData\GridDataServiceProvider',

    ),

At the end of `config/app.php` add `'GridData' => 'Markard\GridData\Facade'` to the `aliases` array

    'aliases' => array(

        'App'        => 'Illuminate\Support\Facades\App',
        'Artisan'    => 'Illuminate\Support\Facades\Artisan',
        ...
        'GridData'   => 'Markard\GridData\Facade',

    ),
    
### Configuration

Run the artisan comand to publish config file

    $ php artisan config:publish markard/grid-data
    
In your `config/packages/markard/grid-data/grid-data.php` set `driver` option.

### Usage

1) Create a new file, for example `UserGridRepository`. Extend it from Markard\GridData\GridDataRepository.

```php
<?php

use Markard\GridData\GridDataRepository;

class UserGridRepository extends GridDataRepository
```

You have to implement one required method:

```php
public function getModel()
{
    return new User();
}
```

2) In you controller:

```php
public function index()
{
    $gridData = GridData::init(new GridUserRepository(), Input::all());
    return View::make('index')->withResponse($gridData->toArray());
}
```

### API

####GridDataRepository.php
* `getModel()` (Required) return Model model.
* `hydrate(\Model $model)` (Optional) return Eloquent Builder. This method executes after `getModel()`.
* `filter($query, array $filters)` (Optional) return null. This method implements all filters to our model or builder if you overrided `hydrate` method. There is already implemented some base functionality for filtering, if you need something more just override it.
`$filters` is an array of Markard\GridData\Filter instances. `Markard\GridData\Filter` is instance with two methods: `getField()` and `getValue()`.
* `sort(array $sorts)` (Optional) return null. This method implements all sorts to our model or builder if you overrided `hydrate` method. There is already implemented some base functionality for sorting, if you need something more just override it.
`$sorts` is an array of Markard\GridData\Sort instances. `Markard\GridData\Sort` is instance with two methods: `getField()` and `getOrder()`.
* `dehydrate(Paginator $paginator)` (Optional) return array. It is the last method before data will be generated. Is you need some special format of the returning data just override this method and return whatever you want.

####ResponseBuilder.php
Instance of this class will be returned after GridData::init was called.

* `filter(array $filters)` set array of `Markard\GridData\Filter` which will be implemented to query.
* `sort(array $sorts)` set array of `Markard\GridData\Sort` which will be implemented to query.
* `page($page)` set current page.
* `pageSize($pageSize)` set page size.
* `toArray()` return array of data + metadata.
* `toJson()` return encoded result of the toArray method.