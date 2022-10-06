<?php

declare(strict_types=1);

namespace Zorachka\Container\Tests\Datasets;

use Zorachka\Container\ServiceProvider;

final class EmptyServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
