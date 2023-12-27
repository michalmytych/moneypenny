<?php

namespace Tests\Feature\Services\Transaction\Budget;

use App\Models\User;
use App\Services\Transaction\Currency\CurrencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CurrencyService $sut Service under testing.
     */
    private readonly CurrencyService $sut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sut = app(CurrencyService::class);
    }

    public function test_currency_service_returns_valid_currency_code(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertNotNull($user->settings);

        $expectedCurrencyCode = 'EUR';

        $user->settings->update(['base_currency_code' => $expectedCurrencyCode]);

        $actualCurrencyCode = $this->sut->resolveCalculationCurrency($user);

        $this->assertEquals($expectedCurrencyCode, $actualCurrencyCode);
    }
}
