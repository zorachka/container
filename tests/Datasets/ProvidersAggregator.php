<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

use Zorachka\Framework\Tests\Datasets\ServiceOne\ServiceOneProvider;
use Zorachka\Framework\Tests\Datasets\ServiceTwo\ServiceTwoProvider;

final class ProvidersAggregator
{
    public static function getProviders(): array
    {
        return [
            ServiceOneProvider::class,
            ServiceTwoProvider::class,
        ];
    }
}
