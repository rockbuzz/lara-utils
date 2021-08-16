<?php

namespace Rockbuzz\LaraUtils\Casts;

use Throwable;
use DomainException;
use Illuminate\Support\Collection;
use Rockbuzz\LaraUtils\Schemaless\Base;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Schemaless implements CastsAttributes
{
    private ?string $class;

    public function __construct(string $class = null)
    {
        $this->class = $class;
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function get($model, string $key, $value, array $attributes)
    {
        throw_if(
            $this->class && !class_exists($this->class),
            new DomainException("The {$this->class} not found")
        );

        return $this->getCastClass(isset($attributes[$key]) ? json_decode($attributes[$key], true) : []);
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        throw_if(
            $value instanceof Collection,
            new DomainException("Value type of Collection not supported.")
        );

        return [$key => json_encode($value instanceof $this->class ? $value : $model->$key->merge($value))];
    }

    private function getCastClass($value): Base
    {
        if ($this->class) {
            return new $this->class($value);
        }

        return new class extends Base {
            protected function getBaseItems(): Collection
            {
                return collect();
            }
        };
    }
}
