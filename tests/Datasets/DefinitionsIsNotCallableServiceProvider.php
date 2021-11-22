<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

use stdClass;
use Zorachka\Framework\Container\ServiceProvider;

final class DefinitionsIsNotCallableServiceProvider implements ServiceProvider
{
    /**
     * @inheritDoc
     */
    public static function getDefinitions(): array
    {
        return [
            stdClass::class => new stdClass()
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getExtensions(): array
    {
        return [];
    }
}
