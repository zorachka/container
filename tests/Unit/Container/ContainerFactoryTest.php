<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zorachka\Framework\Container\ContainerFactory;
use Zorachka\Framework\Container\ServiceProvider;

test('ContainerFactory should throw exception if array of providers is empty', function () {
    ContainerFactory::build([]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if definitions and extensions was not provided', function () {
    ContainerFactory::build([
        new class implements ServiceProvider {
            /**
             * @inheritDoc
             */
            public static function getDefinitions(): array
            {
                return [];
            }

            /**
             * @inheritDoc
             */
            public static function getExtensions(): array
            {
                return [];
            }
        }
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if definitions is not callable', function () {
    ContainerFactory::build([
        new class implements ServiceProvider {
            /**
             * @inheritDoc
             */
            public static function getDefinitions(): array
            {
                return [
                    stdClass::class => new stdClass()
                ];
            }

            /**
             * @inheritDoc
             */
            public static function getExtensions(): array
            {
                return [];
            }
        }
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if extensions is not callable', function () {
    ContainerFactory::build([
        new class implements ServiceProvider {
            /**
             * @inheritDoc
             */
            public static function getDefinitions(): array
            {
                return [];
            }

            /**
             * @inheritDoc
             */
            public static function getExtensions(): array
            {
                return [
                    stdClass::class => new stdClass()
                ];
            }
        }
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should create Psr\Container\ContainerInterface from array of ServiceProvider', function () {
    $container = ContainerFactory::build([
        new class implements ServiceProvider {
            /**
             * @inheritDoc
             */
            public static function getDefinitions(): array
            {
                return [
                    stdClass::class => fn() => new stdClass(),
                ];
            }

            /**
             * @inheritDoc
             */
            public static function getExtensions(): array
            {
                return [];
            }
        }
    ]);

    expect($container)->toBeInstanceOf(ContainerInterface::class);
});

test('ServiceProvider can extend definitions', function () {
    $container = ContainerFactory::build([
        new class implements ServiceProvider {
            /**
             * @inheritDoc
             */
            public static function getDefinitions(): array
            {
                return [
                    stdClass::class => fn() => new stdClass(),
                ];
            }

            /**
             * @inheritDoc
             */
            public static function getExtensions(): array
            {
                return [
                    stdClass::class => function ($stdClass, ContainerInterface $container): stdClass {
                        $stdClass->property = 'value';

                        return $stdClass;
                    }
                ];
            }
        }
    ]);

    $stdClass = $container->get(stdClass::class);
    expect($container)->toBeInstanceOf(ContainerInterface::class);
    expect($stdClass->property)->toBe('value');
});
