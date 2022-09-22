<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets\ServiceTwo;

use Zorachka\Framework\Container\ServiceProvider;
use Zorachka\Framework\Tests\Datasets\Config;

final class ServiceTwoProvider implements ServiceProvider
{
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
            Config::class => static fn(Config $config) => $config->withNewValue('serviceTwoValue')
        ];
    }
}
