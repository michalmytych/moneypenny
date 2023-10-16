<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_login_success(): void
    {
        $user = User::factory()->create();

        $postData = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this
            ->postJson(route('api.login'), $postData)
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->whereType('token', 'string')
                    ->has('user', fn (AssertableJson $json) => $json
                        ->where('id', $user->id)
                        ->whereAllType([
                            'id' => 'integer',
                            'name' => 'string',
                            'email' => 'string',
                            'updated_at' => 'string',
                            'created_at' => 'string',
                            'email_verified_at' => 'string',
                            'is_blocked' => 'integer'
                        ])
                    )
            );
    }

    public function test_login_bad_credentials(): void
    {
        $user = User::factory()->create();

        $postData = [
            'email' => $user->email,
            'password' => 'bad_password'
        ];

        $this
            ->postJson(route('api.login'), $postData)
            ->assertUnauthorized()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->whereAllType([
                        'message' => 'string'
                    ])
            );
    }

    /**
     * @dataProvider provideBadLoginData
     */
    public function test_login_failed_validation(int $expected, array $input): void
    {
        $this
            ->postJson(route('api.login'), $input)
            ->assertStatus($expected)
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('errors', 'array')
                ->whereType('message', 'string')
            );
    }

    public function test_register_success(): void
    {
        $postData = [
            'name' => 'User name',
            'email' => 'test000@gmail.com',
            'password' => 'password123%#@*(!@',
            'password_confirmation' => 'password123%#@*(!@',
        ];

        $this
            ->postJson(route('api.register'), $postData)
            ->assertCreated()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->whereType('token', 'string')
                    ->has('user', fn (AssertableJson $json) => $json
                        ->whereAllType([
                            'id' => 'integer',
                            'name' => 'string',
                            'email' => 'string',
                            'updated_at' => 'string',
                            'created_at' => 'string'
                        ])
                    )
            );
    }

    /**
     * @dataProvider provideBadRegisterData
     */
    public function test_register_failed_validation(int $expected, array $input): void
    {
        $this
            ->postJson(route('api.register'), $input)
            ->assertStatus($expected)
            ->assertJson(fn (AssertableJson $json) => $json
                ->whereType('errors', 'array')
                ->whereType('message', 'string')
            );
    }

    public function test_logout(): void
    {
        $user = User::factory()->create();

        $postData = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $this
            ->postJson(route('api.login'), $postData)
            ->assertOk();

        $this
            ->actingAs($user)
            ->postJson(route('api.logout'), $postData)
            ->assertOk();
    }

    public function test_get_user(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->getJson(route('api.user'))
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->whereType('token', 'null')
                    ->has('user', fn (AssertableJson $json) => $json
                        ->whereAllType([
                            'id' => 'integer',
                            'name' => 'string',
                            'email' => 'string',
                            'updated_at' => 'string',
                            'created_at' => 'string',
                            'email_verified_at' => 'string'
                        ])
                    )
            );
    }

    public static function provideBadRegisterData(): array
    {
        return [
            [
                422,
                [
                    'name' => null,
                    'email' => 'test000@gmail.com',
                    'password' => 'password123%#@*(!@',
                    'password_confirmation' => 'password123%#@*(!@',
                ]
            ],
            [
                422,
                [
                    'name' => 'User name',
                    'email' => 'test000@gmail.com',
                    'password' => 'password123%#@*(!@',
                    'password_confirmation' => '%#@*(!@',
                ]
            ],
            [
                422,
                [
                    'name' => 'User name',
                    'email' => 123,
                    'password' => 'password123%#@*(!@',
                    'password_confirmation' => 'password123%#@*(!@',
                ]
            ],
            [
                422,
                [
                    'name' => 'User name',
                    'email' => 'test',
                    'password' => 'password123%#@*(!@',
                    'password_confirmation' => 'password123%#@*(!@',
                ]
            ]
        ];
    }

    public static function provideBadLoginData(): array
    {
        return [
            [
                422,
                [
                    'email' => 'test',
                    'password' => 'password'
                ]
            ],
            [
                422,
                [
                    'email' => null,
                    'password' => 'password'
                ]
            ],
            [
                422,
                [
                    'email' => 'test@gmail.com',
                    'password' => null
                ]
            ]
        ];
    }
}
