<?php
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use App\Models\User;
use App\Models\Transaction\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Transaction::unsetEventDispatcher();
        $this->refreshDatabase();
    }

    public function test_returns_index_view_is_protected(): void
    {
        $this
            ->routeGet(route('transaction.index'))
            ->assertRedirectToRoute('login');
    }

    public function test_returns_valid_index_view(): void
    {
        $user = User::factory()->create();

        Transaction::factory()->create([
            'user_id' => $user->id,
            'description' => 'HASKELL'
        ]);

        $this
            ->actingAs($user)
            ->routeGet(route('transaction.index'))
            ->assertOk()
            ->assertSee('HASKELL');
    }

    public function test_filters_data_on_index_view(): void
    {
        $user = User::factory()->create();

        Transaction::factory()->create([
            'user_id' => $user->id,
            'description' => 'HASKELL'
        ]);

        Transaction::factory()->create([
            'user_id' => $user->id,
            'description' => 'PASCAL'
        ]);

        $this
            ->actingAs($user)
            ->routeGet(route('transaction.index', [
                'column' => 'description',
                'operator' => 'contains',
                'value' => 'CAL'
            ]))
            ->assertOk()
            ->assertSee('PASCAL')
            ->assertDontSee('HASKELL');
    }

    public function test_returns_show_view_is_protected(): void
    {
        $this
            ->routeGet(route('transaction.show', ['id' => Transaction::factory()->create()->id]))
            ->assertRedirectToRoute('login');
    }
//
//    public function test_returns_valid_show_view(): void {}
//
//    public function test_create_transaction_routes_are_protected(): void {}
//
//    public function test_user_can_create_transaction(): void {}
//
//    public function test_patch_transaction_routes_are_protected(): void {}
//
//    public function test_user_can_patch_transaction(): void {}
}
