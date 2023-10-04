<?php

namespace Test\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;

class UserApiTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_login(): void
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
                    ->whereAllType([
                        'user' => 'array',
                        'token' => 'string'
                    ])
            );
    }
}
