<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\Services\Nordigen;

use Exception;
use Throwable;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Import\Import;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Nordigen\Requisition;
use Illuminate\Support\Facades\Cache;
use App\Models\Synchronization\Account;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\Nordigen\EndUserAgreement;
use App\Models\Synchronization\Synchronization;
use App\Http\Client\Traits\DecodesHttpJsonResponse;
use App\Services\Nordigen\DataObjects\InstitutionDataObject;
use App\Services\Nordigen\DataObjects\TransactionDataObject;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;
use App\Services\Nordigen\Synchronization\NordigenTransactionServiceInterface;

class NordigenService implements TransactionSyncServiceInterface
{
    use DecodesHttpJsonResponse;

    private const NEW_TOKEN_URI = '/api/v2/token/new/';

    private const INSTITUTIONS_URI = '/api/v2/institutions';

    private const NEW_END_USER_AGREEMENTS_URI = '/api/v2/agreements/enduser/';

    private const NEW_REQUISITION_URI = '/api/v2/requisitions/';

    private const ACCOUNTS_URI = '/api/v2/accounts/';

    private const TOKEN_CACHE_KEY = 'nordigen_api_token_data';

    private const INSTITUTIONS_CACHE_KEY = 'nordigen_api_institutions_data';

    private const REQUISITION_CREATED_STATUS = 'CR';

    public function __construct(
        private readonly NordigenClient                      $httpClient,
        private readonly NordigenAccountService              $nordigenAccountService,
        private readonly NordigenTransactionServiceInterface $nordigenTransactionService
    )
    {
    }

    /**
     * @throws GuzzleException
     * @throws Throwable
     */
    public function syncTransactions(mixed $requisitionId, mixed $synchronizationId, User $user): void
    {
        $this->syncAccounts($requisitionId, $synchronizationId, $user);
        $accounts = $this->nordigenAccountService->all($user);

        foreach ($accounts as $account) {
            $import = Import::create([
                'user_id' => $user->id,
                'synchronization_id' => $synchronizationId,
                'status' => Import::STATUS_IMPORTING
            ]);

            try {
                $this->syncTransactionsByAccount($account, $import, $user);
                $import->update(['status' => Import::STATUS_IMPORTED]);

            } catch (Throwable $throwable) {
                $import->update(['status' => Import::STATUS_IMPORT_ERROR]);
                throw $throwable;
            }
        }
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    protected function syncTransactionsByAccount(Account $account, Import $import, User $user): void
    {
        $uri = self::ACCOUNTS_URI . $account->nordigen_account_id . '/transactions/';

        $response = $this->httpClient->get($uri, [
            'headers' => $this->getAuthorizationHeader(),
        ]);

        $transactionsData = $this->decodedResponse($response);

        if (data_get($transactionsData, 'transactions')) {
            $booked = data_get($transactionsData, 'transactions.booked');
            $pending = data_get($transactionsData, 'transactions.pending');

            $all = $booked + $pending;

            foreach ($all as $transactionData) {
                $transactionDataObject = TransactionDataObject::make($transactionData);
                $this->nordigenTransactionService->addNewSynchronizedTransaction(
                    $transactionDataObject,
                    $import,
                    $user
                );
            }
        } else {
            Log::debug(json_encode($transactionsData));
            throw new Exception('Invalid transaction data received. Response was logged to debug logs.');
        }
    }

    public function getAccounts(User $user): Collection
    {
        return Account::whereUser($user)->latest()->get();
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function syncAccounts(mixed $requisitionId, mixed $synchronizationId, User $user): void
    {
        $uri = self::NEW_REQUISITION_URI . $requisitionId . '/';

        $response = $this->httpClient->get($uri, [
            'headers' => $this->getAuthorizationHeader(),
        ]);

        $accountsData = $this->decodedResponse($response);
        $accountsIds = data_get($accountsData, 'accounts');

        if (is_array($accountsIds)) {
            foreach ($accountsIds as $accountId) {
                // @todo add deleting non existing accounts
                Account::firstOrCreate([
                    'user_id' => $user->id,
                    'nordigen_account_id' => $accountId,
                ], [
                    'user_id' => $user->id,
                    'nordigen_account_id' => $accountId,
                    'synchronization_id' => $synchronizationId,
                ]);
            }
        }
    }

    public function getAgreements(User $user): Collection
    {
        return EndUserAgreement::whereUser($user)->with('requisitions')->latest()->get();
    }

    public function getAgreementsByInstitution(User $user, mixed $institutionId): Collection
    {
        return EndUserAgreement::whereUser($user)
            ->with('requisitions')
            ->where('nordigen_institution_id', $institutionId)
            ->latest()
            ->get();
    }

    public function createNewRequisition(mixed $institutionId, mixed $endUserAgreementId, User $user): Requisition|array
    {
        $endUserAgreement = EndUserAgreement::findOrFail($endUserAgreementId);

        if ($endUserAgreement->user_id !== $user->id) {
            abort(403);
        }

        $requestBody = [
            'redirect' => route('institution.agreements', ['id' => $endUserAgreement->getInstitutionId()]),
            'institution_id' => $institutionId,
            'reference' => Str::uuid(),
            'agreement' => $endUserAgreement->nordigen_end_user_agreement_id,
            'user_language' => config('nordigen.user_language'),
        ];

        try {
            $response = $this->httpClient->post(self::NEW_REQUISITION_URI, [
                'json' => $requestBody,
                'headers' => $this->getAuthorizationHeader(),
            ]);

            $requisitionData = $this->decodedResponse($response);
            $isSuccessful = data_get($requisitionData, 'status') === self::REQUISITION_CREATED_STATUS;

            if ($isSuccessful) {
                return Requisition::create([
                    'user_id' => $user->id,
                    'reference' => data_get($requisitionData, 'reference'),
                    'link' => data_get($requisitionData, 'link'),
                    'nordigen_requisition_id' => data_get($requisitionData, 'id'),
                    'raw_response_body' => json_encode($requisitionData),
                    'raw_request_body' => json_encode($requestBody),
                    'end_user_agreement_id' => $endUserAgreement->id,
                    'nordigen_institution_id' => $institutionId,
                ]);
            }

            return [
                'error' => 'Error occurred. Requisition was not created.',
                'response' => [
                    'status_code' => $response->getStatusCode(),
                    'body' => $requisitionData,
                ],
            ];

        } catch (Throwable $throwable) {
            return [
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ];
        }
    }

    public function getExistingAgreementForInstitution(User $user, mixed $institutionId): ?EndUserAgreement
    {
        return EndUserAgreement::firstWhere([
            'user_id' => $user->id,
            'nordigen_institution_id' => $institutionId
        ]);
    }

    public function getAgreementById(User $user, mixed $id): ?EndUserAgreement
    {
        $agreement = EndUserAgreement::findOrFail($id);

        if ($agreement->user_id !== $user->id) {
            abort(403);
        }

        return $agreement;
    }

    public function createNewUserAgreement(User $user, mixed $institutionId): EndUserAgreement|array
    {
        $requestBody = [
            'institution_id' => $institutionId,
            'max_historical_days' => config('nordigen.max_historical_days'),
            'access_valid_for_days' => config('nordigen.access_valid_for_days'),
        ];

        try {
            $response = $this->httpClient->post(self::NEW_END_USER_AGREEMENTS_URI, [
                'json' => $requestBody,
                'headers' => $this->getAuthorizationHeader(),
            ]);

            $userAgreementData = $this->decodedResponse($response);
            $isSuccessful = $response->getStatusCode() > 100 && $response->getStatusCode() < 300;
            $nordigenCreated = data_get($userAgreementData, 'created');

            return EndUserAgreement::create([
                'user_id' => $user->id,
                'is_successful' => $isSuccessful,
                'raw_request_body' => json_encode($requestBody),
                'raw_response_body' => json_encode($userAgreementData),
                'nordigen_institution_id' => data_get($userAgreementData, 'institution_id'),
                'nordigen_end_user_agreement_id' => data_get($userAgreementData, 'id'),
                'nordigen_end_user_agreement_created' => Carbon::parse($nordigenCreated),
            ]);

        } catch (Throwable $throwable) {
            return [
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ];
        }
    }

    /**
     * @return array|InstitutionDataObject[]
     * @noinspection PhpMissingReturnTypeInspection
     * @throws GuzzleException
     */
    public function provideSupportedInstitutionsData()
    {
        if (Cache::missing(self::INSTITUTIONS_CACHE_KEY)) {
            $institutionsData = $this->getFreshSupportedInstitutionsData();

            Cache::put(self::INSTITUTIONS_CACHE_KEY, $institutionsData);

            return $this->getInstitutionsDataObjects($institutionsData);
        }

        $institutionsData = Cache::get(self::INSTITUTIONS_CACHE_KEY);

        return $this->getInstitutionsDataObjects($institutionsData);
    }

    /**
     * @return array|InstitutionDataObject[]
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function getInstitutionsDataObjects(array $institutionsData)
    {
        // @todo - add pagination instead of returning one chunk
        $institutionsData = array_slice($institutionsData, 0, 30);

        return array_map(
            fn($institution) => InstitutionDataObject::make($institution),
            $institutionsData
        );
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getFreshSupportedInstitutionsData(): array
    {
        $requestQuery = [
            // @todo - payments enabled unkonow field obadac po wyczyszczeniu cache
            'payments_enabled' => config('nordigen.payments_enabled'),
            'country' => config('nordigen.country'),
        ];

        $response = $this->httpClient->get(self::INSTITUTIONS_URI, [
            'query' => $requestQuery,
            'headers' => $this->getAuthorizationHeader(),
        ]);

        return $this->decodedResponse($response);
    }

    /**
     * @throws GuzzleException
     */
    public function provideAccessTokenData(): array
    {
        $tokenData = Cache::get(self::TOKEN_CACHE_KEY);
        $tokenExpired = $this->hasTokenRefreshExpired($tokenData);

        if ($tokenExpired || Cache::missing(self::TOKEN_CACHE_KEY)) {
            $tokenData = $this->getFreshTokenData();

            Cache::put(self::TOKEN_CACHE_KEY, $tokenData);

            return $tokenData;
        }

        return $tokenData;
    }

    /**
     * @throws GuzzleException
     */
    public function getFreshTokenData(): array
    {
        $requestBody = [
            'secret_id' => config('nordigen.secret_id'),
            'secret_key' => config('nordigen.secret_key'),
        ];

        $response = $this->httpClient->post(self::NEW_TOKEN_URI, [
            'json' => $requestBody,
        ]);

        return $this->decodedResponse($response);
    }

    /**
     * @throws Exception|GuzzleException
     */
    protected function getAuthorizationHeader(): array
    {
        $tokenData = $this->provideAccessTokenData();
        $accessToken = data_get($tokenData, 'access');

        if (!$accessToken) {
            $gottenData = json_encode($tokenData);
            throw new Exception("Invalid access token data! Got: $gottenData");
        }

        return [
            'Authorization' => "Bearer $accessToken",
        ];
    }

    /**
     * @throws GuzzleException
     */
    public function getInstitutionByExternalId(mixed $institutionId): ?InstitutionDataObject
    {
        $institutions = $this->provideSupportedInstitutionsData();
        $institutions = array_filter($institutions, fn($institution) => $institution->id === $institutionId);
        return collect($institutions)->first();
    }

    public function setStatusSucceeded(Synchronization $synchronization): void
    {
        $synchronization->update([
            'status' => Synchronization::SYNC_STATUS_SUCCEEDED,
            'code' => 200
        ]);
    }

    public function setStatusFailed(Synchronization $synchronization, ?int $status = null): void
    {
        $synchronization->update([
            'status' => Synchronization::SYNC_STATUS_FAILED,
            'code' => $status
        ]);
    }

    protected function hasTokenRefreshExpired(?array $tokenData): bool
    {
        return time() >= (int)data_get($tokenData, 'refresh_expires');
    }
}
