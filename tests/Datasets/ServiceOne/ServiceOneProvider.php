<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets\ServiceOne;

use Zorachka\Framework\Container\ServiceProvider;
use Zorachka\Framework\Tests\Datasets\Config;

final class ServiceOneProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            Config::class => static fn() => Config::withDefaults('defaultValue')
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getExtensions(): array
    {
        return [
            Config::class => static fn(Config $config) => $config->withNewValue('serviceOneValue')
        ];
    }
}
