<?php

namespace Tests\Models;

use Rockbuzz\LaraUtils\Casts\Schemaless;
use Tests\Schemaless\{UserProfile, UserSettings};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'profile',
        'settings',
        'reports'
    ];

    protected $casts = [
        'profile' => Schemaless::class . ':' . UserProfile::class,
        'settings' => Schemaless::class . ':' . UserSettings::class,
        'reports' => Schemaless::class
    ];
}