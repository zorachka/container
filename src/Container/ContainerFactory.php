<?php

declare(strict_types=1);

namespace Zorachka\Framework\Container;

use Exception;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;
use Webmozart\Assert\Assert;
use function DI\decorate;

final class ContainerFactory
{
    private function __construct()
    {
    }

    /**
     * @param class-string<ServiceProvider>[] $providers
     * @return ContainerInterface
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public static function build(array $providers): ContainerInterface
    {
        Assert::notEmpty($providers, 'Please, specify at least one service provider');
        Assert::allImplementsInterface($providers, ServiceProvider::class, 'Must implement Zorachka\Framework\Container\ServiceProvider interface');

        $builder = new ContainerBuilder();
        $builder->useAnnotations(false);

        /** @var class-string<ServiceProvider> $provider */
        foreach ($providers as $provider) {
            $definitions = $provider::getDefinitions();
            $extensions = $provider::getExtensions();

            if (empty($definitions) && empty($extensions)) {
                throw new InvalidArgumentException(
                    \sprintf('Please, specify definitions or extensions in %s', $provider::class)
                );
            }

            Assert::allIsCallable(
                \array_values($definitions),
                \sprintf('All definitions of %s must be `callable`', $provider::class)
            );

            $builder->addDefinitions($definitions);

            if (empty($extensions)) {
                continue;
            }

            $decorated = [];
            foreach ($extensions as $extensionClassName => $callable) {
                Assert::isCallable($callable, \sprintf('Extension of %s must be `callable`', $extensionClassName));

                $decorated[$extensionClassName] = decorate($callable);
            }

            $builder->addDefinitions($decorated);
        }

        return $builder->build();
    }
}
