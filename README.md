<p align="center">
    <a href="https://github.com/zorachka" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/86768962" height="240px">
    </a>
    <h1 align="center">Zorachka Container</h1>
    <br>
</p>

This package provides a factory for [PSR-11](http://www.php-fig.org/psr/psr-11/) compatible
[dependency injection](http://en.wikipedia.org/wiki/Dependency_injection) container that is able to instantiate
and configure classes resolving dependencies and `ServiceProvider` interface.

Uses [PHP-DI](https://php-di.org/) as a core.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zorachka/container.svg?style=flat-square)](https://packagist.org/packages/zorachka/container)
[![Tests](https://github.com/zorachka/container/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/zorachka/container/actions/workflows/run-tests.yml)
[![Analysis](https://github.com/zorachka/container/actions/workflows/analyze.yml/badge.svg?branch=main)](https://github.com/zorachka/container/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/zorachka/container.svg?style=flat-square)](https://packagist.org/packages/zorachka/container)
## Installation

You can install the package via composer:

```bash
composer require zorachka/container
```

## Usage

To create a container you need to pass array of `ServiceProvider` objects interface:

```php
<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zorachka\Container\ContainerFactory;
use Zorachka\Container\ServiceProvider;

$container = ContainerFactory::build([
    new class implements ServiceProvider {
        /**
         * @inheritDoc
         */
        public static function getDefinitions(): array
        {
            return [
                stdClass::class => static fn() => new stdClass(),
            ];
        }

        /**
         * @inheritDoc
         */
        public static function getExtensions(): array
        {
            return [
                stdClass::class => static function ($stdClass, ContainerInterface $container): stdClass {
                    $stdClass->property = 'value';

                    return $stdClass;
                }
            ];
        }
    }
]);

```

## Testing

```bash
make test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Siarhei Bautrukevich](https://github.com/bautrukevich)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
