<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialization;
use Carbon\Carbon;

class DoctorsWorkloadService
{
    public function filterDoctorsData($request)
    {
        $specializations = Specialization::query();
        $doctors = Doctor::query()->with('user');

        if ($request->filled('clinic_id')) {
            $specializations->whereHas('clinics', function ($q) use ($request) {
                $q->where('clinics.id', $request->clinic_id);
            });

            $doctors->where('clinic_id', $request->clinic_id);
        }

        if ($request->filled('specialization_id')) {
            $doctors->whereHas('specializations', function ($q) use ($request) {
                $q->where('specializations.id', $request->specialization_id);
            });
        }

        return [
            'specializations' => $specializations->get(['id', 'name']),
            'doctors' => $doctors->get(),
        ];
    }

    public function getDoctorsWorkloadData($validated)
    {
        $records = $this->filter($validated);
        $groupedData = $this->groupRecordsByDoctor($records);
        $doctorsWorkload = $groupedData['doctorsWorkload'];

        $startDate = isset($validated['start_date']) && $validated['start_date']
            ? Carbon::parse($validated['start_date'])->format('d.m.Y')
            : null;
        $endDate = isset($validated['end_date']) && $validated['end_date']
            ? Carbon::parse($validated['end_date'])->format('d.m.Y')
            : null;

        $clinicName = request('clinic_id') && $records->isNotEmpty()
            ? $records->first()->clinic->name
            : 'Всі клініки';

        $specializationName = request('specialization_id') && $records->isNotEmpty()
            ? $records->first()->service->specialization->name
            : 'Всі спеціалізації';

        return compact('doctorsWorkload', 'startDate', 'endDate', 'records', 'clinicName', 'specializationName');
    }

    public function filter(array $data)
    {
        $query = Appointment::query()->with(['doctor.user', 'service.specialization', 'clinic']);

        if (!empty($data['start_date']) && !empty($data['end_date'])) {
            $query->whereBetween('appointment_date', [$data['start_date'], $data['end_date']]);
        }

        if (!empty($data['clinic_id'])) {
            $query->where('clinic_id', $data['clinic_id']);
        }

        if (!empty($data['specialization_id'])) {
            $query->whereHas('service.specialization', function ($q) use ($data) {
                $q->where('id', $data['specialization_id']);
            });
        }

        if (!empty($data['doctor_id'])) {
            $query->where('doctor_id', $data['doctor_id']);
        }

        return $query->get();
    }

    private function groupRecordsByDoctor($records)
    {
        $doctorsWorkload = $records->groupBy(function ($record) {
            $user = $record->doctor->user;
            return "{$user->first_name} {$user->last_name} ({$user->email})";
        });

        return ['doctorsWorkload' => $doctorsWorkload];
    }
}
