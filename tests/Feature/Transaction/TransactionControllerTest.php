<?php

namespace Tests\Feature\Transaction;

use App\Models\Transaction\Transaction;
use App\Models\User;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    public function test_returns_index_view_is_protected(): void
    {
        $this
            ->routeGet(route('transaction.index'))
            ->assertRedirectToRoute('login');
    }

    public function test_returns_valid_index_view(): void
    {
        $this
            ->actingAs(User::factory()->create())
            ->routeGet(route('transaction.index'))
            ->assertOk();
    }

//    @todo
//    public function test_filters_data_on_index_view(): void {}
//
//    public function test_returns_show_view_is_protected(): void {}
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
