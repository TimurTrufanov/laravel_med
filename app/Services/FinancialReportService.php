<?php

namespace App\Services;

use App\Models\AppointmentAnalysis;
use App\Models\AppointmentService;
use App\Models\Clinic;
use Carbon\Carbon;

class FinancialReportService
{
    public function generateReport(array $filters)
    {
        $startDate = isset($filters['start_date']) && $filters['start_date']
            ? Carbon::parse($filters['start_date'])->startOfDay()
            : null;

        $endDate = isset($filters['end_date']) && $filters['end_date']
            ? Carbon::parse($filters['end_date'])->endOfDay()
            : null;

        $type = $filters['type'] ?? null;
        $clinicName = 'Всі клініки';
        $records = collect();

        if (!empty($filters['clinic_id'])) {
            $clinic = Clinic::find($filters['clinic_id']);
            $clinicName = $clinic ? $clinic->name : $clinicName;
        }

        if ($type === 'analyses' || $type === null) {
            $query = AppointmentAnalysis::query()
                ->with('analysis', 'appointment.clinic')
                ->where('status', 'завершений');

            if (!empty($filters['clinic_id'])) {
                $query->whereHas('appointment', function ($q) use ($filters) {
                    $q->where('clinic_id', $filters['clinic_id']);
                });
            }

            if ($startDate && $endDate) {
                $query->whereBetween('appointment_date', [$startDate, $endDate]);
            }

            $analyses = $query->get()->groupBy(fn($item) => $item->analysis->name ?? 'Unknown');

            $records = $records->merge($analyses->map(fn($items, $name) => [
                'name' => $name,
                'price' => $items->first()->price,
                'quantity' => $items->sum('quantity'),
                'total_price' => $items->sum('total_price'),
            ]));
        }

        if ($type === 'services' || $type === null) {
            $query = AppointmentService::query()
                ->with('service', 'appointment.clinic');

            if (!empty($filters['clinic_id'])) {
                $query->whereHas('appointment', function ($q) use ($filters) {
                    $q->where('clinic_id', $filters['clinic_id']);
                });
            }

            if ($startDate && $endDate) {
                $query->whereHas('appointment', fn($q) => $q->whereBetween('appointment_date', [$startDate, $endDate]));
            }

            $services = $query->get()->groupBy(fn($item) => $item->service->name ?? 'Unknown');

            $records = $records->merge($services->map(fn($items, $name) => [
                'name' => $name,
                'price' => $items->first()->price,
                'quantity' => $items->sum('quantity'),
                'total_price' => $items->sum('total_price'),
            ]));
        }

        $totalSum = $records->sum('total_price');

        return compact('records', 'totalSum', 'startDate', 'endDate', 'clinicName', 'type');
    }
}
