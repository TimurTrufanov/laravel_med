<?php

namespace App\Services;

use App\Models\CardRecord;
use Carbon\Carbon;

class DiseaseStatisticsService
{
    public function filter(array $data)
    {
        $query = CardRecord::query()->with(['diagnosis', 'appointment.clinic']);

        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
        }

        if (!empty($data['clinic_id'])) {
            $query->whereHas('appointment', function ($q) use ($data) {
                $q->where('clinic_id', $data['clinic_id']);
            });
        }

        if (!empty($data['diagnosis_id'])) {
            $query->where('diagnosis_id', $data['diagnosis_id']);
        }

        return $query->get();
    }

    private function groupRecordsByDiagnosis($records)
    {
        $customDiagnosesCount = $records->whereNull('diagnosis_id')->count();
        $diagnosisCounts = $records->whereNotNull('diagnosis_id')->groupBy('diagnosis.name');

        return [
            'customDiagnosesCount' => $customDiagnosesCount,
            'diagnosisCounts' => $diagnosisCounts,
        ];
    }

    public function getDiseaseStatisticsData(array $validated)
    {
        $records = $this->filter($validated);
        $groupedData = $this->groupRecordsByDiagnosis($records);

        $startDate = isset($validated['start_date']) && $validated['start_date']
            ? Carbon::parse($validated['start_date'])->format('d.m.Y')
            : null;

        $endDate = isset($validated['end_date']) && $validated['end_date']
            ? Carbon::parse($validated['end_date'])->format('d.m.Y')
            : null;

        $clinicName = request('clinic_id') && $records->isNotEmpty()
            ? $records->first()->appointment->clinic->name
            : 'Всі клініки';

        return array_merge($groupedData, compact('records', 'startDate', 'endDate', 'clinicName'));
    }
}
