<?php

namespace Tests\Feature\Http\Api\Transaction;

use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\ApiTestCase;

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
