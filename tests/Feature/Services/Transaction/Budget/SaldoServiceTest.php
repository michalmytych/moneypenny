<?php

namespace Tests\Feature\Services\Transaction\Budget;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;
use App\Transaction\PersonalAccount\SaldoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Feature\Traits\CreatesTransactionForUser;
use Tests\TestCase;

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
        /** @var User $user */
        $user = User::factory()->create();

        $userDefaultPersonalAccount = $user->personalAccounts->first();

        $this->createTransactionForUser($user, [
            'transaction_date' => Carbon::yesterday(),
            'accounting_date' => Carbon::yesterday(),
            'raw_volume' => '120.00',
            'calculation_volume' => 120.00,
            'decimal_volume' => 120.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUser($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '-50.00',
            'calculation_volume' => 50.00,
            'decimal_volume' => 50.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '-50.00',
            'calculation_volume' => 50.00,
            'decimal_volume' => 50.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->assertEquals(expected: 70.00, actual: $this->sut->getByUser($user));
    }
}
