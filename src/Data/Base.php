<?php

declare(strict_types = 1);

namespace Rockbuzz\LaraUtils\Data;

use ErrorException;
use Illuminate\Support\Str;

abstract class Base
{
    protected array $item;

    public function __construct(array $item = [])
    {
        $this->item = $item;
    }

    public static function make(array $item)
    {
        return new static($item);
    }

    public function __get($property)
    {
        if (method_exists($this, $method = Str::camel("get_{$property}_attribute"))) {
            return call_user_func([$this, $method]);
        }

        if (array_key_exists($property, $this->item)) {
            return $this->item[$property];
        }

        $class = get_class($this);

        throw new ErrorException("Undefined property: {$class}::{$property}");
    }
}
