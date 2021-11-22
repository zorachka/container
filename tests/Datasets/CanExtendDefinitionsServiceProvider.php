<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

use stdClass;
use Psr\Container\ContainerInterface;
use Zorachka\Framework\Container\ServiceProvider;

final class CanExtendDefinitionsServiceProvider implements ServiceProvider
{
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
