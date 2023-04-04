<?php

declare(strict_types=1);

namespace Zorachka\Container\Tests\Datasets;

use stdClass;
use Zorachka\Container\ServiceProvider;

final class DefinitionsIsNotCallableServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            stdClass::class => new stdClass(),
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
