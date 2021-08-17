<?php

namespace Tests\Schemaless;

use Rockbuzz\LaraUtils\Schemaless\Base;

class UserProfile extends Base
{
    protected array $default = [
        'biography' => null,
        'document' => null,
        'address' => [
            'street' => null,
            'zip_code' => null
        ]
    ];
}