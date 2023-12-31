<?php

namespace Tests\Feature\Services\Transaction\Budget;

use App\Moneypenny\Transaction\Models\Transaction;
use App\Moneypenny\User\Models\User;
use App\Transaction\Transaction\TransactionQuerySet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\Feature\Traits\CreatesTransactionForUser;
use Tests\TestCase;

class TransactionQuerySetTest extends TestCase
{
    use RefreshDatabase, CreatesTransactionForUser, WithFaker;

    /**
     * @var TransactionQuerySet $sut Service under testing.
     */
    private readonly TransactionQuerySet $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = app(TransactionQuerySet::class);
    }

    public function test_returns_valid_today_expenses_having_other_transactions(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $userDefaultPersonalAccount = $user->personalAccounts->first();

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::yesterday(),
            'accounting_date' => Carbon::yesterday(),
            'raw_volume' => '-120.00',
            'calculation_volume' => 120.00,
            'decimal_volume' => 120.00,
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

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '-20.00',
            'calculation_volume' => 20.00,
            'decimal_volume' => 20.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '-20.00',
            'calculation_volume' => 20.00,
            'decimal_volume' => 20.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => true
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '40.00',
            'calculation_volume' => 40.00,
            'decimal_volume' => 40.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $result = $this->sut->getExpendituresTodayTotal($user);

        $this->assertEquals(70.0, $result);
    }

    public function test_returns_valid_this_week_expenses_having_other_transactions(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $userDefaultPersonalAccount = $user->personalAccounts->first();

        $randomWednesday = $this->generateRandomDateByDayOfWeek(3);

        $this->travelTo($randomWednesday);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday)->subDays(8),
            'accounting_date' => (clone $randomWednesday)->subDays(8),
            'raw_volume' => '-120.00',
            'calculation_volume' => 120.00,
            'decimal_volume' => 120.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday),
            'accounting_date' => (clone $randomWednesday),
            'raw_volume' => '-50.00',
            'calculation_volume' => 50.00,
            'decimal_volume' => 50.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday),
            'accounting_date' => (clone $randomWednesday),
            'raw_volume' => '-50.00',
            'calculation_volume' => 50.00,
            'decimal_volume' => 50.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => true
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday)->subDay(),
            'accounting_date' => (clone $randomWednesday)->subDay(),
            'raw_volume' => '40.00',
            'calculation_volume' => 40.00,
            'decimal_volume' => 40.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $result = $this->sut->getExpendituresThisWeekTotal($user);

        $this->assertEquals(50.0, $result);
    }

    public function test_returns_valid_today_incomes_having_other_transactions(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $userDefaultPersonalAccount = $user->personalAccounts->first();

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::yesterday(),
            'accounting_date' => Carbon::yesterday(),
            'raw_volume' => '-120.00',
            'calculation_volume' => 120.00,
            'decimal_volume' => 120.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '50.00',
            'calculation_volume' => 50.00,
            'decimal_volume' => 50.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '-20.00',
            'calculation_volume' => 20.00,
            'decimal_volume' => 20.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '40.00',
            'calculation_volume' => 40.00,
            'decimal_volume' => 40.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => Carbon::today(),
            'accounting_date' => Carbon::today(),
            'raw_volume' => '40.00',
            'calculation_volume' => 40.00,
            'decimal_volume' => 40.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => true
        ]);

        $result = $this->sut->getIncomesTodayTotal($user);

        $this->assertEquals(90.0, $result);
    }

    public function test_returns_valid_this_week_incomes_having_other_transactions(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $userDefaultPersonalAccount = $user->personalAccounts->first();

        $randomWednesday = $this->generateRandomDateByDayOfWeek(3);

        $this->travelTo($randomWednesday);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday)->subDays(8),
            'accounting_date' => (clone $randomWednesday)->subDays(8),
            'raw_volume' => '-120.00',
            'calculation_volume' => 120.00,
            'decimal_volume' => 120.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday),
            'accounting_date' => (clone $randomWednesday),
            'raw_volume' => '-50.00',
            'calculation_volume' => 50.00,
            'decimal_volume' => 50.00,
            'type' => Transaction::TYPE_EXPENDITURE,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday)->subDay(),
            'accounting_date' => (clone $randomWednesday)->subDay(),
            'raw_volume' => '40.00',
            'calculation_volume' => 40.00,
            'decimal_volume' => 40.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => false
        ]);

        $this->createTransactionForUserWithoutEvents($user, [
            'transaction_date' => (clone $randomWednesday)->subDay(),
            'accounting_date' => (clone $randomWednesday)->subDay(),
            'raw_volume' => '40.00',
            'calculation_volume' => 40.00,
            'decimal_volume' => 40.00,
            'type' => Transaction::TYPE_INCOME,
            'personal_account_id' => $userDefaultPersonalAccount->id,
            'is_excluded_from_calculation' => true
        ]);

        $result = $this->sut->getIncomesThisWeekTotal($user);

        $this->assertEquals(40.0, $result);
    }

    /**
     * Generate random past date of specific week day.
     *
     * @param int $dayOfWeek 0 for Sunday, etc.
     *
     * @return Carbon
     */
    public function generateRandomDateByDayOfWeek(int $dayOfWeek): Carbon
    {
        $date = Carbon::today();
        $date->startOfWeek()->addDays($dayOfWeek);

        $randomWeeksAgo = rand(1, 52);
        $date->subWeeks($randomWeeksAgo);

        return $date;
    }
}
