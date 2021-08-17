<?php

declare(strict_types=1);

namespace Rockbuzz\LaraUtils\Schemaless;

use Illuminate\Support\Collection;

class Base extends Collection
{
    protected array $default = [];

    public function __construct($items = [])
    {
        $this->items = array_merge(
            $this->default,
            $this->getArrayableItems($items)
        );
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value): void
    {
        $this->put($key, $value);
    }

    public function __isset($key): bool
    {
        return $this->has($key);
    }

    public function set($key, $value): self
    {
        data_set($this->items, $key, $value);

        return $this;
    }
}
