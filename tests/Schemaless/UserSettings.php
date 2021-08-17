<?php

namespace Tests\Schemaless;

use Rockbuzz\LaraUtils\Schemaless\Base;

class UserSettings extends Base
{
    protected array $default = [
        'email_notification' => true,
        'push_notification' => false,
        'theme' => 'default',
        'modules' => [
            'products' => false,
            'users' => false
        ]
    ];
}