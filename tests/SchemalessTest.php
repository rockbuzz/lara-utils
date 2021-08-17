<?php

namespace Tests;

use ErrorException;
use Tests\Models\User;
use Tests\Schemaless\{UserProfile, UserSettings};
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchemalessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function must_create_model_with_default_values()
    {
        $user = User::create();

        $this->assertEquals([
            'biography' => null,
            'document' => null,
            'address' => [
                'street' => null,
                'zip_code' => null
            ]
        ], $user->profile->toArray());
        $this->assertEquals([
            'email_notification' => true,
            'push_notification' => false,
            'theme' => 'default',
            'modules' => [
                'products' => false,
                'users' => false
            ]
        ], $user->settings->toArray());
        $this->assertEquals([], $user->reports->toArray());
    }

    /** @test */
    public function must_access_property()
    {
        $user = User::create([
            'profile' => [
                'biography' => $biography = 'Test'
            ],
            'reports' => [
                'report 1',
                'report 2',
                'report 3'
            ]
        ]);

        $this->assertEquals($user->profile['biography'], $biography);
        $this->assertEquals($user->profile->get('biography'), $biography);
        $this->assertEquals($user->profile->biography, $biography);
        $this->assertTrue($user->profile->has('biography'));
        $this->assertEquals(3, $user->reports->count());
    }

    /** @test */
    public function must_set_property_as_object()
    {
        $user = new User();
        $user->profile->biography = 'Test set';
        $user->profile->address = [
            'zip_code' => '12345678'
        ];
        $user->settings->email_notification = false;
        $user->settings->push_notification = true;
        $user->settings->set('modules.products', true);
        $user->save();

        $this->assertDatabaseHas('users', [
            'profile' => json_encode([
                'biography' => 'Test set',
                'document' => null,
                'address' => [
                    'zip_code' => '12345678'
                ]
            ], JSON_THROW_ON_ERROR),
            'settings' => json_encode([
                'email_notification' => false,
                'push_notification' => true,
                'theme' => 'default',
                'modules' => [
                    'products' => true,
                    'users' => false
                ]
            ], JSON_THROW_ON_ERROR)
        ]);
    }

    /** @test */
    public function must_set_property_as_array()
    {
        $user = new User();
        $user->profile['biography'] = 'Test set';
        $user->profile['address'] = [
            'zip_code' => '12345678'
        ];
        $user->settings['email_notification'] = false;
        $user->settings['push_notification'] = true;
        $user->settings->set('modules.products', true);
        $user->save();

        $this->assertDatabaseHas('users', [
            'profile' => json_encode([
                'biography' => 'Test set',
                'document' => null,
                'address' => [
                    'zip_code' => '12345678'
                ]
            ], JSON_THROW_ON_ERROR),
            'settings' => json_encode([
                'email_notification' => false,
                'push_notification' => true,
                'theme' => 'default',
                'modules' => [
                    'products' => true,
                    'users' => false
                ]
            ], JSON_THROW_ON_ERROR)
        ]);
    }

    /** @test */
    public function must_override_as_object()
    {
        $user = User::create();
        $user->profile = new UserProfile([
            'biography' => 'Test set',
            'address' => [
                'zip_code' => '12345678'
            ]
        ]);

        $user->settings = new UserSettings([
            'email_notification' => false,
            'push_notification' => true,
        ]);

        $user->settings->set('modules.products', true);
        $user->reports->push('report 1');
        $user->save();

        $this->assertDatabaseHas('users', [
            'profile' => json_encode([
                'biography' => 'Test set',
                'document' => null,
                'address' => [
                    'zip_code' => '12345678'
                ]
            ], JSON_THROW_ON_ERROR),
            'settings' => json_encode([
                'email_notification' => false,
                'push_notification' => true,
                'theme' => 'default',
                'modules' => [
                    'products' => true,
                    'users' => false
                ]
            ], JSON_THROW_ON_ERROR),
            'reports' => json_encode(['report 1'], JSON_THROW_ON_ERROR)
        ]);
    }

    /** @test */
    public function must_override_as_array()
    {
        $user = User::create();
        $user->profile = [
            'biography' => 'Test set',
            'address' => [
                'zip_code' => '12345678'
            ]
        ];
        $user->settings = [
            'email_notification' => false,
            'push_notification' => true,
        ];
        $user->settings->set('modules.products', true);
        $user->reports->push('report 1');
        $user->save();

        $this->assertDatabaseHas('users', [
            'profile' => json_encode([
                'biography' => 'Test set',
                'document' => null,
                'address' => [
                    'zip_code' => '12345678'
                ]
            ], JSON_THROW_ON_ERROR),
            'settings' => json_encode([
                'email_notification' => false,
                'push_notification' => true,
                'theme' => 'default',
                'modules' => [
                    'products' => true,
                    'users' => false
                ]
            ], JSON_THROW_ON_ERROR),
            'reports' => json_encode(['report 1'], JSON_THROW_ON_ERROR)
        ]);
    }

    /** @test */
    public function not_support_must_override_as_collection()
    {
        $user = User::create();

        $this->expectException(ErrorException::class);

        $user->profile = collect([
            'biography' => 'Test set',
            'address' => [
                'zip_code' => '12345678'
            ]
        ]);
        $user->save();

        $this->assertDatabaseMissing('users', [
            'profile' => json_encode([
                'biography' => 'Test set',
                'document' => null,
                'address' => [
                    'zip_code' => '12345678'
                ]
            ], JSON_THROW_ON_ERROR)
        ]);
    }
}
