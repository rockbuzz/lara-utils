<?php

namespace Rockbuzz\LaraUtils\Casts;

use Illuminate\Support\Collection;
use Throwable;
use DomainException;
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
     * @throws Throwable
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $this->getCastClass(isset($attributes[$key]) ? json_decode($attributes[$key], true) : []);
    }

    /**
     * @throws Throwable
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        return [$key => json_encode($value instanceof Base ? $value : $model->$key->merge($value))];
    }

    /**
     * @throws Throwable
     */
    private function getCastClass($value): Base
    {
        if ($this->class) {
            throw_if(!class_exists($this->class), new DomainException("The {$this->class} not found"));

            return new $this->class($value);
        }

        return new Base($value);
    }
}
