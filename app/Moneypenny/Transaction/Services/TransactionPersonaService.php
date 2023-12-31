<?php

namespace App\Transaction\Transaction;

use App\Moneypenny\Persona\Models\Persona;
use App\Moneypenny\Transaction\Models\Transaction;
use App\Shared\Helpers\StringHelper;
use Illuminate\Support\Str;

class TransactionPersonaService
{
    // @todo - personas should only be searched in transactions of one specific user

    public const ACCEPTED_SIMILARITY_PERCENTAGE = 10;

    /** @noinspection PhpUndefinedMethodInspection */
    public function createPersonasAssociations(Transaction $transaction): void
    {
        $transactionId = $transaction->id;
        $senderAccountNumber = $transaction->sender_account_number;
        $receiverAccountNumber = $transaction->receiver_account_number;

        $senderSearchColumnData = $transaction->sender
            ? $transaction->sender
            : $transaction->description;

        $receiverSearchColumnData = $transaction->receiver
            ? $transaction->receiver
            : $transaction->description;

        $senderAssociatedPersona = $this->findOrCreateAssociation($senderSearchColumnData, $senderAccountNumber);
        $receiverAssociatedPersona = $this->findOrCreateAssociation($receiverSearchColumnData, $receiverAccountNumber);

        Transaction::where('id', $transactionId)->update([
            'sender_persona_id' => $senderAssociatedPersona->id,
            'receiver_persona_id' => $receiverAssociatedPersona->id
        ]);
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

        foreach ($this->getPersonaNameSearchRules() as $rule) {
            if (null === $persona && $personaAccountNumber) {
                $persona = $rule($personaAccountNumber);
            }
        }

        foreach ($this->getPersonaAccountNumberSearchRules() as $rule) {
            if (null === $persona && $personaName) {
                $persona = $rule($personaName);
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
        $personasContainingLongestWordCursor = Persona::where('associated_names', 'like', '%' . $longestWord . '%')->cursor();

        $avgSimilarityRates = $personasContainingLongestWordCursor
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
