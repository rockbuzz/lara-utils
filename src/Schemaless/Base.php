<?php

declare(strict_types=1);

namespace Rockbuzz\LaraUtils\Schemaless;

use JsonSerializable;
use Illuminate\Support\Collection;

abstract class Base implements JsonSerializable
{
    private Collection $items;

    public function __construct(array $items)
    {
        $this->items = $this->getBaseItems()->merge($items);
    }

    public function get($key, $default = null)
    {
        return $this->items->get($key, $default);
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function has($key): bool
    {
        return $this->items->has($key);
    }

    public function merge($items): self
    {
        $this->items = $this->items->merge($items);

        return $this;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value): void
    {
        $this->items->put($key, $value);
    }

    public function __isset($key): bool
    {
        return $this->items->has($key);
    }

    public function jsonSerialize(): array
    {
        return $this->items->toArray();
    }

    abstract protected function getBaseItems(): Collection;
}
