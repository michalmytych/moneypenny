<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\Nordigen;

use Throwable;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Models\Nordigen\Requisition;
use Illuminate\Support\Facades\Cache;
use App\Models\Nordigen\EndUserAgreement;
use App\Http\Client\Traits\DecodesHttpJsonResponse;
use App\Nordigen\DataObjects\InstitutionDataObject;
use App\Contracts\Services\Transaction\TransactionSyncServiceInterface;

class NordigenService implements TransactionSyncServiceInterface
{
    use DecodesHttpJsonResponse;

    private const NEW_TOKEN_URI = '/api/v2/token/new/';

    private const INSTITUTIONS_URI = '/api/v2/institution/';

    private const NEW_END_USER_AGREEMENTS_URI = '/api/v2/agreements/enduser/';

    private const NEW_REQUISITION_URI = '/api/v2/requisitions/';

    private const TOKEN_CACHE_KEY = 'nordigen_api_token_data';

    private const INSTITUTIONS_CACHE_KEY = 'nordigen_api_institutions_data';

    private const REQUISITION_CREATED_STATUS = 'CR';

    public function __construct(private NordigenClient $httpClient) { }

    public function getNewTransactions()
    {
        // @TODO: Implement
    }

    public function getAgreements(): Collection
    {
        return EndUserAgreement::with('requisitions')->latest()->get();
    }

    public function getAgreementsByInstitution(mixed $institutionId): Collection
    {
        return EndUserAgreement::with('requisitions')
            ->where('nordigen_institution_id', $institutionId)
            ->latest()
            ->get();
    }

    public function createNewRequisition(mixed $institutionId, mixed $endUserAgreementId): Requisition|array
    {
        $endUserAgreement = EndUserAgreement::findOrFail($endUserAgreementId);

        $requestBody = [
            'redirect'       => route('institution.agreements', ['id' => $endUserAgreement->getInstitutionId()]),
            'institution_id' => $institutionId,
            'reference'      => Str::uuid(),
            'agreement'      => $endUserAgreement->nordigen_end_user_agreement_id,
            'user_language'  => config('nordigen.user_language'),
        ];

        try {
            $response = $this->httpClient->post(self::NEW_REQUISITION_URI, [
                'json'    => $requestBody,
                'headers' => $this->getAuthorizationHeader(),
            ]);

            $requisitionData = $this->decodedResponse($response);
            $isSuccessful    = data_get($requisitionData, 'status') === self::REQUISITION_CREATED_STATUS;

            if ($isSuccessful) {
                return Requisition::create([
                    'reference'               => data_get($requisitionData, 'reference'),
                    'link'                    => data_get($requisitionData, 'link'),
                    'nordigen_requisition_id' => data_get($requisitionData, 'id'),
                    'raw_response_body'       => json_encode($requisitionData),
                    'raw_request_body'        => json_encode($requestBody),
                    'end_user_agreement_id'   => $endUserAgreement->id,
                    'nordigen_institution_id' => $institutionId,
                ]);
            }

            return [
                'error'    => 'Error occurred. Requisition was not created.',
                'response' => [
                    'status_code' => $response->getStatusCode(),
                    'body'        => $requisitionData,
                ],
            ];

        } catch (Throwable $throwable) {
            return [
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ];
        }
    }

    public function getExistingAgreementForInstitution(mixed $institutionId): ?EndUserAgreement
    {
        return EndUserAgreement::firstWhere('nordigen_institution_id', $institutionId);
    }

    public function getAgreementById(mixed $id): EndUserAgreement
    {
        return EndUserAgreement::findOrFail($id);
    }

    public function createNewUserAgreement(mixed $institutionId): EndUserAgreement|array
    {
        $requestBody = [
            'institution_id'        => $institutionId,
            'max_historical_days'   => config('nordigen.max_historical_days'),
            'access_valid_for_days' => config('nordigen.access_valid_for_days'),
        ];

        try {
            $response = $this->httpClient->post(self::NEW_END_USER_AGREEMENTS_URI, [
                'json'    => $requestBody,
                'headers' => $this->getAuthorizationHeader(),
            ]);

            $userAgreementData = $this->decodedResponse($response);
            $isSuccessful      = $response->getStatusCode() > 100 && $response->getStatusCode() < 300;
            $nordigenCreated   = data_get($userAgreementData, 'created');

            return EndUserAgreement::create([
                'is_successful'                       => $isSuccessful,
                'raw_request_body'                    => json_encode($requestBody),
                'raw_response_body'                   => json_encode($userAgreementData),
                'nordigen_institution_id'             => data_get($userAgreementData, 'institution_id'),
                'nordigen_end_user_agreement_id'      => data_get($userAgreementData, 'id'),
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

    public function getFreshSupportedInstitutionsData(): array
    {
        $requestQuery = [
            'payments_enabled' => config('nordigen.payments_enabled'),
            'country'          => config('nordigen.country'),
        ];

        try {
            $response = $this->httpClient->get(self::INSTITUTIONS_URI, [
                'query'   => $requestQuery,
                'headers' => $this->getAuthorizationHeader(),
            ]);

            return $this->decodedResponse($response);

        } catch (Throwable $throwable) {
            return [
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ];
        }
    }

    public function provideAccessTokenData(): array
    {
        if (Cache::missing(self::TOKEN_CACHE_KEY)) {
            $tokenData = $this->getFreshTokenData();

            Cache::put(self::TOKEN_CACHE_KEY, $tokenData);

            return $tokenData;
        }

        return Cache::get(self::TOKEN_CACHE_KEY);
    }

    public function getFreshTokenData(): array
    {
        $requestBody = [
            'secret_id'  => config('nordigen.secret_id'),
            'secret_key' => config('nordigen.secret_key'),
        ];

        try {
            $response = $this->httpClient->post(self::NEW_TOKEN_URI, [
                'json' => $requestBody,
            ]);

            return $this->decodedResponse($response);

        } catch (Throwable $throwable) {
            return [
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ];
        }
    }

    /**
     * @throws Exception
     */
    protected function getAuthorizationHeader(): array
    {
        $tokenData   = $this->provideAccessTokenData();
        $accessToken = data_get($tokenData, 'access');

        if (!$accessToken) {
            $gottenData = json_encode($tokenData);
            throw new Exception("Invalid access token data! Got: $gottenData");
        }

        return [
            'Authorization' => "Bearer $accessToken",
        ];
    }

    public function getInstitutionByExternalId(mixed $institutionId): ?InstitutionDataObject
    {
        $institutions = $this->provideSupportedInstitutionsData();
        $institutions = array_filter($institutions, fn($institution) => $institution->id === $institutionId);
        return collect($institutions)->first();
    }
}
