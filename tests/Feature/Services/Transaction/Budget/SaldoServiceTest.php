<?php

namespace Tests\Feature\Services\Transaction\Budget;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CreatesTransactionForUser;
use App\Services\Transaction\PersonalAccount\SaldoService;

class SaldoServiceTest extends TestCase
{
    use RefreshDatabase, CreatesTransactionForUser;

    /**
     * @var SaldoService $sut Service under testing.
     */
    private readonly SaldoService $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = app(SaldoService::class);
    }

    public function test_returns_valid_account_saldo_for_user(): void
    {
    }
}
