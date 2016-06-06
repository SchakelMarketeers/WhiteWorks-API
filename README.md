# WhiteWorks API client for PHP

[![Build status][ci]][ci-link]
[![Coverage Status][cov]][cov-link]

A WhiteWorks API client for PHP5.5+, based on Guzzle 6

## Features

 - Read-only access for most API endpoints
 - Models for each kind of response, which are Iterable, Json Serializable and
   have array access.
 - Extensive Unit Tests with code coverage
 - [GPLv3 License][license]

## License

The software is licensed under a [GPLv3 license][license]. We chose this license
to invite others to help improve this repository, instead of improving it and
keeping the code closed-source.

In case this does not meet your business needs, please contact us.

## Installation

The easiest way to start using this library, is by installing it via [Composer][getcomposer].

```
composer require schakel/whiteworks-api
```

If that doesn't work, you can download or clone the repository and add the
following Namespace link to your PSR-4 compatible autoloader:

|Namespace              |Path                               |
|-                      |-                                  |
|`\Schakel\WhiteWorks`  |`[path-to-whiteworks-api]/src/`    |

You can also choose to manually load all the PHP files you need, but that's a
Very Bad Idea™.

## Usage

### Constructing a client
The main client can be found as `Schakel\WhiteWorks\Client`. As this is an
extension of the Guzzle-based [JSON-RPC client][json-client], calling the
constructor requires a few presets, which can be easily loade using the
`Client::factory` method.

The Factory method requires an `api_key` and a `hostname`. These are expected
as the first and only argument of `Client::factory`.

```php
<?php

$client = Schakel\WhiteWorks\Client::factory([
    'api_key' => 'YOUR-API-KEY',
    'hostname' => 'YOUR-BUSINESS-NAME.whiteworks.nl'
]);
```

Optionally, you can add `'debug' => true` to get more debug messages. This is,
ofcourse, not recommended for production systems.

### Getting an API
The `Schakel\WhiteWorks\Client` has a getApi method, that will return the
correct Api for the entity you'd like to retrieve. A list of APIs can be found
[in the doc/ folder](doc/APIs.md).

## Examples

### Retrieving all contacts
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Schakel\WhiteWorks\Client;

$client = Client::factory([
    'api_key': 'ci2ahp7eebeir3Oochai9oo4aWe7ac' // Your API key
    'hostname': 'mycompany.whiteworks.nl' // Hostname, /without/ scheme
]);

$allClients = $client->getApi('contact')->getAll();

foreach ($allClients as $client) {
    echo "{$client->getName()}\n";
}

```

<!-- TODO more examples -->

## Contributing

You are free to help contributing to the project. Please open an issue, so
everyone stays on the same level.

[ci]: https://travis-ci.org/SchakelMarketeers/WhiteWorks-API.svg?branch=master
[ci-link]: https://travis-ci.org/SchakelMarketeers/WhiteWorks-API
[cov]: https://coveralls.io/repos/github/SchakelMarketeers/WhiteWorks-API/badge.svg?branch=master
[cov-link]: https://coveralls.io/github/SchakelMarketeers/WhiteWorks-API?branch=master
[license]: LICENSE
[getcomposer]: https://getcomposer.org/
