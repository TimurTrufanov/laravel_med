<?php

namespace App\Rules;

use App\Models\DaySheet;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDaySheetOverlap implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    protected ?int $doctorId;
    protected ?string $startTime;
    protected ?string $endTime;
    protected ?int $daySheetId;

    public function __construct(?int $doctorId, ?string $startTime, ?string $endTime, ?int $daySheetId = null)
    {
        $this->doctorId = $doctorId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->daySheetId = $daySheetId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->doctorId === null || $this->startTime === null || $this->endTime === null) {
            return;
        }

        $overlapExists = DaySheet::where('doctor_id', $this->doctorId)
            ->where('date', $value)
            ->where(function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('start_time', '<', $this->endTime)
                        ->where('end_time', '>', $this->startTime);
                });
            })
            ->when($this->daySheetId, function ($query) {
                $query->where('id', '!=', $this->daySheetId);
            })
            ->exists();

        if ($overlapExists) {
            $fail('Вказаний час перетинається з існуючим розкладом для цього лікаря.');
        }
    }
}
