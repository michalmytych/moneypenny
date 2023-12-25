<?php

namespace Tests\Feature\Api\Transaction;

use App\Models\User;
use Tests\ApiTestCase;
use App\Models\Transaction\Transaction;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionApiTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_gets_valid_transactions_list(): void
    {
        $user = User::factory()->create();

        Transaction::factory(5)->create([
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson(
                route('api.transaction.index')
            );

        $response
            ->assertJson(
                fn(AssertableJson $json) => $json
                    ->hasValidPagination()
                    ->has('data', 5)
            );

        $response->assertOk();
    }
}
