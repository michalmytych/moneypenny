<?php

namespace Tests\Feature\Services\Transaction\Budget;

use App\Moneypenny\Budget\Models\Budget;
use App\Moneypenny\PersonalAccount\Models\PersonalAccount;
use App\Moneypenny\User\Models\User;
use App\Transaction\Budget\BudgetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CreatesTransactionForUser;
use Tests\TestCase;

class BudgetServiceTest extends TestCase
{
    use RefreshDatabase, CreatesTransactionForUser;

    /**
     * @var BudgetService $sut Service under testing.
     */
    private readonly BudgetService $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = app(BudgetService::class);
    }

    public function test_creates_budgets_on_user_without_budgets(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertEmpty($user->budgets);

        $this->sut->allWithConsumption($user);

        $this->assertNotEmpty($user->budgets);
    }

    /**
     * @dataProvider accountsAndBudgetsData
     */
    public function test_creates_valid_budgets_on_user(array $accountsValues, array $expectedBudgetsAmounts): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var PersonalAccount $personalAccount */
        $personalAccount = $user->personalAccounts->first();

        // Currently 'Default' personal account is created by UserObserver
        $this->assertNotNull($personalAccount);

        $personalAccount->update([
            'value' => $accountsValues[0]
        ]);

        PersonalAccount::create([
            'user_id' => $user->id,
            'value' => $accountsValues[1],
            'name' => 'personal budget 2'
        ]);

        PersonalAccount::create([
            'user_id' => $user->id,
            'value' => $accountsValues[2],
            'name' => 'personal budget 3'
        ]);

        $this->sut->allWithConsumption($user);

        $user->load('budgets');

        $dayBudget = $user->budgets->firstWhere('type', Budget::TYPE_DAY);
        $weekBudget = $user->budgets->firstWhere('type', Budget::TYPE_WEEK);
        $monthBudget = $user->budgets->firstWhere('type', Budget::TYPE_MONTH);

        $this->assertEquals($expectedBudgetsAmounts['month'], $monthBudget->amount);
        $this->assertEquals($expectedBudgetsAmounts['week'], $weekBudget->amount);
        $this->assertEquals($expectedBudgetsAmounts['day'], $dayBudget->amount);
    }

    public static function accountsAndBudgetsData(): array
    {
        return [
            '20.000 PLN accounts value sum' => [
                [10_000, 5_000, 5_000],
                [
                    'month' => round(10_000),
                    'week' => round(2_500),
                    'day' => round(2_500 / 30)
                ],
            ],
            '5.000 PLN accounts value sum' => [
                [1_000, 2_000, 2_000],
                [
                    'month' => round(2_500),
                    'week' => round(2_500 / 4),
                    'day' => round((2_500 / 4) / 30)
                ],
            ],
            '0 PLN accounts value sum' => [
                [0, 0, 0],
                [
                    'month' => round(2_500),
                    'week' => round(2_500 / 4),
                    'day' => round((2_500 / 4) / 30)
                ],
            ]
        ];
    }
}
