<?php

declare(strict_types=1);

namespace Zorachka\Container\Tests\Unit\Container;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use stdClass;
use Zorachka\Container\ContainerFactory;
use Zorachka\Container\Tests\Datasets\DefinitionsIsNotCallableServiceProvider;
use Zorachka\Container\Tests\Datasets\EmptyServiceProvider;
use Zorachka\Container\Tests\Datasets\ExtensionsIsNotCallableServiceProvider;
use Zorachka\Container\Tests\Datasets\SimpleServiceProvider;

/**
 * @internal
 */
final class ContainerFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionIfArrayOfProvidersIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfDefinitionsIsNotServiceProvider(): void
    {
        $this->expectException(InvalidArgumentException::class);
        /* @phpstan-ignore-next-line */
        (new ContainerFactory())->build([
            stdClass::class,
        ]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldThrowExceptionIfDefinitionsAndExtensionsWereNotProvided(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([
            EmptyServiceProvider::class,
        ]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfDefinitionsIsNotCallable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([
            DefinitionsIsNotCallableServiceProvider::class,
        ]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfExtensionsIsNotCallable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new ContainerFactory())->build([
            ExtensionsIsNotCallableServiceProvider::class,
        ]);
    }

    /**
     * @test
     * @throws Exception
     */
    public function shouldCreatePsrContainerFromArrayOfServiceProviders(): void
    {
        $container = (new ContainerFactory())->build([
            SimpleServiceProvider::class,
        ]);

        Assert::assertInstanceOf(ContainerInterface::class, $container);
    }
}
