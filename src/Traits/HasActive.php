<?php

namespace Rockbuzz\LaraUtils\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasActive
{
    public function isActive(): bool
    {
        return $this->active;
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('active', true);
    }
}
