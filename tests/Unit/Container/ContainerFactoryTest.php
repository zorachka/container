<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zorachka\Framework\Container\ContainerFactory;
use Zorachka\Framework\Tests\Datasets\CanExtendDefinitionsServiceProvider;
use Zorachka\Framework\Tests\Datasets\DefinitionsIsNotCallableServiceProvider;
use Zorachka\Framework\Tests\Datasets\EmptyServiceProvider;
use Zorachka\Framework\Tests\Datasets\ExtensionsIsNotCallableServiceProvider;
use Zorachka\Framework\Tests\Datasets\SimpleServiceProvider;

test('ContainerFactory should throw exception if array of providers is empty', function () {
    ContainerFactory::build([]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if provider class name is not ServiceProvider', function () {
    ContainerFactory::build([
        stdClass::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if definitions and extensions was not provided', function () {
    ContainerFactory::build([
        EmptyServiceProvider::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if definitions is not callable', function () {
    ContainerFactory::build([
        DefinitionsIsNotCallableServiceProvider::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if extensions is not callable', function () {
    ContainerFactory::build([
        ExtensionsIsNotCallableServiceProvider::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should create Psr\Container\ContainerInterface from array of ServiceProvider', function () {
    $container = ContainerFactory::build([
        SimpleServiceProvider::class,
    ]);

    expect($container)->toBeInstanceOf(ContainerInterface::class);
});

test('ServiceProvider can extend definitions', function () {
    $container = ContainerFactory::build([
        CanExtendDefinitionsServiceProvider::class,
    ]);

    $stdClass = $container->get(stdClass::class);
    expect($container)->toBeInstanceOf(ContainerInterface::class);
    expect($stdClass->property)->toBe('value');
});
