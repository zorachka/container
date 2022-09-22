<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zorachka\Framework\Container\ContainerFactory;
use Zorachka\Framework\Tests\Datasets\CanExtendDefinitionsServiceProvider;
use Zorachka\Framework\Tests\Datasets\Config;
use Zorachka\Framework\Tests\Datasets\DefinitionsIsNotCallableServiceProvider;
use Zorachka\Framework\Tests\Datasets\EmptyServiceProvider;
use Zorachka\Framework\Tests\Datasets\ExtensionsIsNotCallableServiceProvider;
use Zorachka\Framework\Tests\Datasets\ProvidersAggregator;
use Zorachka\Framework\Tests\Datasets\SimpleServiceProvider;

test('ContainerFactory should throw exception if array of providers is empty', function () {
    (new ContainerFactory())->build([]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if provider class name is not ServiceProvider', function () {
    (new ContainerFactory())->build([
        stdClass::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if definitions and extensions was not provided', function () {
    (new ContainerFactory())->build([
        EmptyServiceProvider::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if definitions is not callable', function () {
    (new ContainerFactory())->build([
        DefinitionsIsNotCallableServiceProvider::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should throw exception if extensions is not callable', function () {
    (new ContainerFactory())->build([
        ExtensionsIsNotCallableServiceProvider::class,
    ]);
})->throws(InvalidArgumentException::class);

test('ContainerFactory should create Psr\Container\ContainerInterface from array of ServiceProvider', function () {
    $container = (new ContainerFactory())->build([
        SimpleServiceProvider::class,
    ]);

    expect($container)->toBeInstanceOf(ContainerInterface::class);
});

test('ServiceProvider can extend definitions', function () {
    $container = (new ContainerFactory())->build([
        CanExtendDefinitionsServiceProvider::class,
    ]);

    $stdClass = $container->get(stdClass::class);
    expect($container)->toBeInstanceOf(ContainerInterface::class);
    expect($stdClass->property)->toBe('value');
});

test('ContainerFactory should not cache container if compilation path doesn\'t exists', function () {
    $container = (new ContainerFactory())->build([
        SimpleServiceProvider::class,
    ]);

    expect($container)->toBeInstanceOf(ContainerInterface::class);
    expect(file_exists( __DIR__ . '/CompiledContainer.php'))->toBeFalse();
});

test('ContainerFactory should cache container if compilation path exists', function () {
    $container = (new ContainerFactory(__DIR__))->build([
        SimpleServiceProvider::class,
    ]);

    $file = __DIR__ . '/CompiledContainer.php';
    expect($container)->toBeInstanceOf(ContainerInterface::class);
    expect(file_exists($file))->toBeTrue();
    unlink($file);
});

test('ContainerFactory should can be able to create container from ProvidersAggregator', function () {
    $container = (new ContainerFactory())->build(
        ProvidersAggregator::getProviders()
    );

    /** @var Config $config */
    $config = $container->get(Config::class);
    expect($config->getValue())->toBe('serviceTwoValue');
});
