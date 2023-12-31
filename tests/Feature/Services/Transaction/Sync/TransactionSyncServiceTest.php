<?php

namespace Tests\Feature\Services\Transaction\Sync;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use App\Models\Nordigen\Requisition;
use Illuminate\Support\Facades\Cache;
use App\Models\Nordigen\EndUserAgreement;
use App\Models\Synchronization\Synchronization;
use App\Services\Nordigen\NordigenClientInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;
use App\Services\Nordigen\Synchronization\NordigenTransactionServiceInterface;

class TransactionSyncServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_syncs_accounts_and_transactions_when_external_service_responses_with_success(): void
    {
        Cache::clear();

        $user = $this->setUpUser();
        $requisition = $this->setUpUserRequisition($user);
        $synchronization = $this->setUpSynchronization($user);

        $this->assertNotNull($user->personalAccounts->first());

        $clientMock = Mockery::mock(NordigenClientInterface::class);
        $transactionServiceMock = Mockery::mock(NordigenTransactionServiceInterface::class);

        $clientMock
            ->shouldReceive('post')
            ->andReturn(
                new Response(body: json_encode(
                    [
                        'refresh_expires' => now()->addDay()->timestamp,
                        'access' => 'FAKE_EXTERNAL_API_ACCESS_TOKEN'
                    ]
                ))
            );

        $clientMock
            ->shouldReceive('get')
            ->times(3)
            ->andReturn(
                new Response(body: json_encode(
                    [
                        'accounts' => ['FAKE_EXTERNAL_ACCOUNT_RECORD_ID']
                    ]
                )),
                new Response(body: json_encode(
                    [
                        'balances' => [
                            [
                                'balanceAmount' => [
                                    'amount' => '17404.79',
                                    'currency' => 'PLN'
                                ],
                                'balanceType' => 'forwardAvailable'
                            ],
                        ]
                    ]
                )),
                new Response(body: json_encode(
                    [
                        'transactions' => [
                            'booked' => [
                                [
                                    'transactionAmount' => [
                                        'amount' => '100.00',
                                        'currency' => 'PLN',
                                    ],
                                    'valueDate' => now()->subDay()->toIso8601String(),
                                    'bookingDate' => now()->subDay()->toIso8601String(),
                                    'debtorName' => 'FAKE',
                                    'creditorName' => 'FAKE',
                                    'remittanceInformationUnstructured' => 'FAKE',
                                    'debtorAccount' => [
                                        'iban' => 'IBAN-FAKE-FAKE-FAKE'
                                    ],
                                    'creditorAccount' => [
                                        'iban' => 'IBAN-FAKE-FAKE-FAKE'
                                    ],
                                    'personalAccountId' => $user->personalAccounts->first()->id,
                                ]
                            ],
                            'pending' => [],
                        ]
                    ]
                ))
            );

        $transactionServiceMock->shouldReceive('addNewSynchronizedTransaction')->once();

        $this->instance(NordigenClientInterface::class, $clientMock);
        $this->instance(NordigenTransactionServiceInterface::class, $transactionServiceMock);

        $serviceUnderTesting = app(TransactionSyncServiceInterface::class);

        $serviceUnderTesting->syncTransactions($requisition->id, $synchronization->id, $user);
    }

    private function setUpUser(): User
    {
        return User::factory()->create();
    }

    private function setUpSynchronization(User $user): Synchronization
    {
        return Synchronization::create(['user_id' => $user->id]);
    }

    private function setUpUserRequisition(User $user): Requisition
    {
        $agreement = EndUserAgreement::create([
            'is_successful' => 1,
            'raw_request_body' => '{"institution_id": "ALIOR_ALBPPLPW", "max_historical_days": 90, "access_valid_for_days": 30}',
            'raw_response_body' => '{"id": "24a5816f - 613a - 4c68 - a326 - 14603fd2330b", "created": "2023 - 12 - 30T23:17:38.165808Z", "accepted": null, "access_scope": ["balances", "details", "transactions"], "institution_id": "ALIOR_ALBPPLPW", "max_historical_days": 90, "access_valid_for_days": 30}',
            'nordigen_institution_id' => 'ALIOR_ALBPPLPW',
            'nordigen_end_user_agreement_id' => '24a5816f-613a-4c68-a326-14603fd2330b',
            'nordigen_end_user_agreement_created' => '2023-12-30 23:17:38',
            'user_id' => $user->id,
        ]);

        return Requisition::create([
            'reference' => '22d4f1d5-9125-48b8-a106-f0b5173fd40c',
            'raw_request_body' => '{"redirect": "http://localhost:8000/institutions/ALIOR_ALBPPLPW/agreements", "agreement": "24a5816f-613a-4c68-a326-14603fd2330b", "reference": "22d4f1d5-9125-48b8-a106-f0b5173fd40c", "user_language": "PL", "institution_id": "ALIOR_ALBPPLPW"}',
            'raw_response_body' => '{"id": "656359ea-e65e-49a0-80c8-b3c31da3520d", "ssn": null, "link": "https://ob.nordigen.com/psd2/start/656359ea-e65e-49a0-80c8-b3c31da3520d/ALIOR_ALBPPLPW", "status": "CR", "created": "2023-12-30T23:17:42.325946Z", "accounts": [], "redirect": "http://localhost:8000/institutions/ALIOR_ALBPPLPW/agreements", "agreement": "24a5816f-613a-4c68-a326-14603fd2330b", "reference": "22d4f1d5-9125-48b8-a106-f0b5173fd40c", "user_language": "PL", "institution_id": "ALIOR_ALBPPLPW", "account_selection": false, "redirect_immediate": false}',
            'link' => 'https://ob.nordigen.com/psd2/start/656359ea-e65e-49a0-80c8-b3c31da3520d/ALIOR_ALBPPLPW',
            'nordigen_institution_id' => 'ALIOR_ALBPPLPW',
            'nordigen_requisition_id' => '656359ea-e65e-49a0-80c8-b3c31da3520d',
            'end_user_agreement_id' => $agreement->id,
            'user_id' => $user->id,
        ]);
    }
}
