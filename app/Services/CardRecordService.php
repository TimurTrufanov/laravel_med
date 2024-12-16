<?php

namespace App\Services;


use App\Models\User;
use Exception;

class CardRecordService
{
    /**
     * @throws Exception
     */
    public function getCardRecordsBySpecialization(int $specializationId, int $userId)
    {
        $cards = User::find($userId)->patient->cards()->with(['records', 'specialization'])->get();

        $cardRecords = $cards->flatMap(function ($card) use ($specializationId) {
            if ($card->specialization_id == $specializationId) {
                return $card->records;
            }
            return [];
        });

        if ($cardRecords->isEmpty()) {
            throw new Exception('Записів для цієї спеціалізації не знайдено.');
        }

        return $cardRecords->sortByDesc('created_at');
    }
}
