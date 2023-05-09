<?php

namespace App\Services\Transaction;

use Illuminate\Support\Str;
use App\Models\Transaction\Persona;
use App\Services\Helpers\StringHelper;
use App\Models\Transaction\Transaction;

class TransactionPersonaService
{
    public const ACCEPTED_SIMILARITY_PERCENTAGE = 10;

    /** @noinspection PhpUndefinedMethodInspection */
    public function createPersonasAssociations(Transaction $transaction): void
    {
        $transactionId = $transaction->id;
        $senderSearchColumnData = $transaction->sender ? $transaction->sender : $transaction->description;
        $receiverSearchColumnData = $transaction->receiver ? $transaction->receiver : $transaction->description;
        $senderAccountNumber = $transaction->sender_account_number;
        $receiverAccountNumber = $transaction->receiver_account_number;

        $senderAssociatedPersona = $this->findOrCreateAssociation($senderSearchColumnData, $senderAccountNumber);
        Transaction::where('id', $transactionId)->update(['sender_persona_id' => $senderAssociatedPersona->id]);

        $receiverAssociatedPersona = $this->findOrCreateAssociation($receiverSearchColumnData, $receiverAccountNumber);
        Transaction::where('id', $transactionId)->update(['receiver_persona_id' => $receiverAssociatedPersona->id]);
    }

    protected function findOrCreateAssociation(?string $personaName, ?string $personaAccountNumber): Persona
    {
        $persona = $this->runPersonaSearchRules($personaName, $personaAccountNumber);
        $anyData = $personaName || $personaAccountNumber;

        if (null !== $persona) {
            $this->updatePersonaNames($persona, $personaName);
        }

        if (null === $persona && $anyData) {
            $associatedNamesData = $personaName ? [$this->getStringNormalizedForAssociation($personaName)] : [];

            if ($personaName) {
                $commonName = $this->getNamesCommonParts($associatedNamesData, $personaName);
            }

            $associatedNamesDataEncoded = json_encode($associatedNamesData);

            $persona = Persona::create([
                'common_name' => $commonName ?? Persona::NAME_UNKNOWN,
                'account_number' => $personaAccountNumber ?? Persona::ACCOUNT_NUMBER_UNKNOWN,
                'associated_names' => $associatedNamesDataEncoded
            ]);
        }

        return $persona;
    }

    protected function runPersonaSearchRules(?string $personaName, ?string $personaAccountNumber): ?Persona
    {
        $persona = null;
        $nameSearchRules = $this->getPersonaNameSearchRules();
        $accountNumberSearchRules = $this->getPersonaAccountNumberSearchRules();

        foreach ($accountNumberSearchRules as $rule) {
            if (null === $persona && $personaAccountNumber) {
                $persona = $rule($personaAccountNumber);
            }
        }

        if (null === $persona) {
            foreach ($nameSearchRules as $rule) {
                if (null === $persona && $personaName) {
                    $persona = $rule($personaName);
                }
            }
        }

        return $persona;
    }

    protected function getPersonaNameSearchRules(): array
    {
        return [
            'exact_name' => fn($name) => $this->findPersonaByExactlySameName($name),
            'similar_name' => fn($name) => $this->findPersonaByAvgAssociatedNamesSimilarity($name),
        ];
    }

    protected function getPersonaAccountNumberSearchRules(): array
    {
        return [
            'same_account_number' => fn($name) => $this->findPersonaByAccountNumber($name),
        ];
    }

    /** @noinspection PhpUndefinedMethodInspection */
    protected function findPersonaByExactlySameName(string $personaName): ?Persona
    {
        $value = $this->getStringNormalizedForAssociation($personaName);
        $condition = 'json_contains(associated_names, \'["' . $value . '"]\')';
        return Persona::whereRaw($condition)->limit(1)->first();
    }

    protected function getStringNormalizedForAssociation(string $string): string
    {
        $toReplace = ['"', '`', "'", "\\"];
        $string = str_replace($toReplace, '', $string);
        $string = stripslashes($string);
        $string = stripcslashes($string);
        $string = preg_replace('|/|', '', $string);
        $string = Str::lower($string);
        return StringHelper::removeAccents($string);
    }

    /** @noinspection PhpUndefinedMethodInspection */
    protected function findPersonaByAvgAssociatedNamesSimilarity(string $personaName): ?Persona
    {
        $personaName = $this->getStringNormalizedForAssociation($personaName);
        $words = collect(explode(' ', $personaName));
        $longestWord = $words->max(fn($word) => strlen($word));
        $personasContainingLongesWordCursor = Persona::where('associated_names', 'like', '%' . $longestWord . '%')->cursor();

        $avgSimilarityRates = $personasContainingLongesWordCursor
            ->map(function (Persona $persona) use ($personaName) {
                $associatedNames = json_decode($persona->associated_names);
                $similarityPercentageRates = [];

                foreach ($associatedNames as $associatedName) {
                    similar_text($associatedName, $personaName, $percentage);
                    $similarityPercentageRates[] = $percentage;
                }

                $averageSimilarity = array_sum($similarityPercentageRates) / count($similarityPercentageRates);

                if ($averageSimilarity < self::ACCEPTED_SIMILARITY_PERCENTAGE) {
                    return null;
                }

                return [
                    'persona' => $persona,
                    'avg_similarity_rate' => $averageSimilarity,
                ];
            })->filter();

        $mostSimilar = null;

        if ($avgSimilarityRates->count() > 0) {
            $highestRateData = $avgSimilarityRates->sortByDesc('avg_similarity_rate')->first();
            $mostSimilar = $highestRateData['persona'];
        }

        return $mostSimilar;
    }

    /** @noinspection PhpUndefinedMethodInspection */
    protected function findPersonaByAccountNumber(string $accountNumber): ?Persona
    {
        return Persona::where('account_number', $accountNumber)->get()->first();
    }

    protected function updatePersonaNames(Persona $persona, ?string $personaName): void
    {
        $associatedNames = json_decode($persona->associated_names, true);
        $alreadySaved = in_array($personaName, $associatedNames);

        if (!$alreadySaved) {
            $associatedNames[] = $personaName;
            $newCommonName = $this->getNamesCommonParts($associatedNames, $personaName);

            $persona->update([
                'associated_names' => $associatedNames,
                'common_name' => $newCommonName
            ]);
        }
    }

    protected function getNamesCommonParts(array $names, ?string $default = null): string
    {
        $newCommonName = StringHelper::findLongestCommonSubstringInArray($names);

        if (!$newCommonName) {
            if ($default) {
                $newCommonName = $default;
            } else {
                $newCommonName = data_get($names, 0, Persona::NO_COMMON_NAMES);
            }
        }

        return $newCommonName;
    }
}
