<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

use Zorachka\Framework\Container\ServiceProvider;

final class EmptyServiceProvider implements ServiceProvider
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
        return [];
    }
}
