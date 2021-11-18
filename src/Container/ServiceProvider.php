<?php

declare(strict_types=1);

namespace Zorachka\Framework\Container;

interface ServiceProvider
{
    /**
     * @return array<class-string|string, callable>
     */
    public static function getDefinitions(): array;

    /**
     * @return array<class-string|string, callable>
     */
    public static function getExtensions(): array;
}
