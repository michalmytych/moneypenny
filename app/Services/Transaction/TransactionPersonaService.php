<?php

namespace App\Services\Transaction;

use App\Models\Transaction\Persona;
use App\Models\Transaction\Transaction;

class TransactionPersonaService
{
    public const ACCEPTED_SIMILARITY_PERCENTAGE = 0.7;

    public function createPersonasAssociations(int $transactionId, ?string $transactionSender, ?string $transactionReceiver): void
    {
        if (null !== $transactionSender) {
            $senderAssociatedPersona = $this->findOrCreateAssociation($transactionSender);
            Transaction::where('id', $transactionId)->update(['sender_persona_id' => $senderAssociatedPersona->id]);
        }

        if (null !== $transactionReceiver) {
            $receiverAssociatedPersona = $this->findOrCreateAssociation($transactionReceiver);
            Transaction::where('id', $transactionId)->update(['receiver_persona_id' => $receiverAssociatedPersona->id]);
        }
    }

    private function findOrCreateAssociation(string $transactionReceiver): Persona
    {
        $persona = $this->runPersonaSearchRules($transactionReceiver);

        if (null === $persona) {
            $persona = Persona::create([
                'common_name' => $transactionReceiver,
                'associated_names' => json_encode([$transactionReceiver])
            ]);
        }

        return $persona;
    }

    protected function runPersonaSearchRules(string $personaName): ?Persona
    {
        $searchRules = $this->getPersonaSearchRules();
        $persona = null;

        foreach ($searchRules as $rule) {
            if (null === $persona) {
                $persona = $rule($personaName);
            }
        }

        return $persona;
    }

    protected function getPersonaSearchRules(): array
    {
        return [
            'exact_name' => fn($name) => $this->findPersonaByExactlySameName($name),
            'similar_name' => fn($name) => $this->findPersonaByAvgAssociatedNamesSimilarity($name),
        ];
    }

    private function findPersonaByExactlySameName(string $personaName): ?Persona
    {
        return Persona::where('associated_names', 'like', '%' . $personaName . '%')->limit(1)->first();
    }

    private function findPersonaByAvgAssociatedNamesSimilarity(string $personaName): ?Persona
    {
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
}
