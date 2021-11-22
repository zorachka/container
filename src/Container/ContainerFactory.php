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
    private string $compilationPath;

    public function __construct(
        string $compilationPath = '',
    ) {
        $this->compilationPath = $compilationPath;
    }

    /**
     * @param class-string<ServiceProvider>[] $providers
     * @return ContainerInterface
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build(array $providers): ContainerInterface
    {
        Assert::notEmpty($providers, 'Please, specify at least one service provider');

        $builder = new ContainerBuilder();
        $builder->useAnnotations(false);

        if ($this->compilationPath !== '') {
            $builder->enableDefinitionCache();
            $builder->enableCompilation($this->compilationPath);
            $builder->ignorePhpDocErrors(true);
        }

        /** @var class-string<ServiceProvider> $providerClassName */
        foreach ($providers as $providerClassName) {
            if (!is_a($providerClassName, ServiceProvider::class, true)) {
                throw new InvalidArgumentException(sprintf(
                    'Class "%s" was expected to implement "%s"',
                    $providerClassName,
                    ServiceProvider::class
                ));
            }

            $definitions = $providerClassName::getDefinitions();
            $extensions = $providerClassName::getExtensions();

            if (empty($definitions) && empty($extensions)) {
                throw new InvalidArgumentException(
                    \sprintf('Please, specify definitions or extensions in %s', $providerClassName)
                );
            }

            Assert::allIsCallable(
                \array_values($definitions),
                \sprintf('All definitions of %s must be `callable`', $providerClassName)
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
