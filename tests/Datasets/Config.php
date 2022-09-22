<?php

declare(strict_types=1);

namespace Zorachka\Framework\Tests\Datasets;

final class Config
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function withDefaults(string $value = ''): self
    {
        return new self($value);
    }

    public function withNewValue(string $value): self
    {
        $new = clone $this;
        $new->value = $value;

        return $new;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
