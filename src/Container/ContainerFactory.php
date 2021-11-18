<?php

declare(strict_types=1);

namespace Zorachka\Framework\Container;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use function DI\decorate;

final class ContainerFactory
{
    /**
     * @param class-string<ServiceProvider>[] $providers
     * @return ContainerInterface
     * @throws \Exception
     */
    public static function build(array $providers): ContainerInterface
    {
        $builder = new ContainerBuilder();
        $builder->useAnnotations(false);

        /** @var class-string<ServiceProvider> $provider */
        foreach ($providers as $provider) {
            $builder->addDefinitions(
                $provider::getDefinitions()
            );

            $extensions = $provider::getExtensions();
            if (empty($extensions)) {
                continue;
            }

            $decorated = [];

            foreach ($extensions as $extensionClassName => $callable) {
                $decorated[$extensionClassName] = decorate($callable);
            }

            $builder->addDefinitions($decorated);
        }

        return $builder->build();
    }
}
