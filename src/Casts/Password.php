<?php

namespace Rockbuzz\LaraUtils\Casts;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Password implements CastsAttributes
{
    /** @inheritDoc */
    public function get($model, string $key, $value, array $attributes): string
    {
        return $value;
    }

    /** @inheritDoc */
    public function set($model, string $key, $value, array $attributes): string
    {
        return Hash::needsRehash($value) ? Hash::make($value) : $value;
    }
}
