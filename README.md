# LaraGus
Based on gusapi/gusapi package. Adapted to the Laravel environment for easy integration.

## Installation
```
composer require xgrz/laragus
```

## API Key (required)
This package requires api key. You can get it from GUS for free. 
Official docs and registration can be found at [GUS API](https://api.stat.gov.pl/Home/RegonApi)

Once you get your api key place it in .env file:
> GUS_API_KEY=c443ml3o4fko4okf4o8b

## Usage (backend)

```
<?php

    $vatId = 'VAT_ID_NUMBER';

    Xgrz\LaravelGusDataFetcher\Services\GusService::nip($vatId)->toCollection();
    // or
    Xgrz\LaravelGusDataFetcher\Services\GusService::nip($vatId)->toArray();
```
Typically, one record is returned. The exception is when the entrepreneur is also a farmer. Implement a solution that always checks all returned data.

Method return array/collection. Example: 

```
array [
    0 => array [
        "company_name" => "ACME Limited"
        "city" => "Warsaw"
        "post_code" => "02-226"
        "street" => "ul. Kamyczkowa"
        "property_number" => "201"
        "apartment_number" => "21"
        "vat_id" => "9678907766"
    ]
]

```

## Usage (ajax requests)

By default:
- package expose api/ajax route for external requests
- default route name is **ajax.gus**
- default uri is **/ajax.gus**
- no middlewares! (route is public! - see config section)
- you can modify url, route name, add middleware or disable this feature in config file (see config section)

Typical request should be like: 
> GET: example.com/ajax/gus?vat_id=1231231212


## Configuration

To be able to change the default behavior please publish config by executing command:
```
 php artisan vendor:publish vendor:publish --tag="laragus-config"
```

Config file will be placed in your config app directory (/config/laragus.php).

### Block api exposition:
``` 
'expose_api_route' => false     // default true
```
Setting expose_api_route to false prevents api calls.

### Changed exposed api route name:
``` 
'api_route_name' => 'your_route_name'   // default ajax.gus
```
Set your own route name for api calls.

### Changed uri of exposed resource:
``` 
'api_uri' => 'gus-data-fetch'   // default ajax/gus
```
Set your own url for api calls.


### Use laravel middleware for protecting route:
``` 
'middleware' => ['web', 'auth']    // default is ['web'] - no middlewares
```
Protect route with your own laravel middleware. 

