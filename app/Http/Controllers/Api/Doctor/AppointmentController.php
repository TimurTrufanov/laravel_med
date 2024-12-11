<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctor\AppointmentRequest;
use App\Http\Requests\Api\Doctor\AppointmentStatusRequest;
use App\Models\Analysis;
use App\Models\Appointment;
use App\Models\Card;
use App\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function addDetails(AppointmentRequest $request, $appointmentId)
    {
        DB::beginTransaction();

        try {
            $appointment = Appointment::with('service.specialization')->findOrFail($appointmentId);

            $card = Card::firstOrCreate([
                'patient_id' => $appointment->patient_id,
                'specialization_id' => $appointment->service->specialization_id,
            ]);

            if ($request->filled('medical_history') || $request->filled('treatment') || $request->filled('diagnosis_id') || $request->filled('custom_diagnosis')) {
                $card->records()->create([
                    'doctor_id' => $request->user()->doctor->id,
                    'appointment_id' => $appointment->id,
                    'medical_history' => $request->medical_history,
                    'diagnosis_id' => $request->diagnosis_id,
                    'custom_diagnosis' => $request->custom_diagnosis,
                    'treatment' => $request->treatment,
                ]);
            }

            foreach ($request->analyses as $analysisData) {
                $analysis = Analysis::findOrFail($analysisData['analysis_id']);
                $appointment->appointmentAnalyses()->create([
                    'analysis_id' => $analysis->id,
                    'price' => $analysis->price,
                    'quantity' => $analysisData['quantity'],
                    'total_price' => $analysis->price * $analysisData['quantity'],
                    'appointment_date' => now(),
                    'recommended_date' => $analysisData['recommended_date'] ?? null,
                ]);
            }

            foreach ($request->services as $serviceData) {
                $service = Service::findOrFail($serviceData['service_id']);
                $appointment->appointmentServices()->create([
                    'service_id' => $service->id,
                    'price' => $service->price,
                    'quantity' => $serviceData['quantity'],
                    'total_price' => $service->price * $serviceData['quantity'],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Запис успішно додано.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => ['general' => [$e->getMessage()]]], 422);
        }
    }


    public function getDetails($appointmentId)
    {
        try {
            $appointment = Appointment::with([
                'patient.user',
                'service.specialization',
                'appointmentAnalyses.analysis',
                'appointmentServices.service',
                'cardRecords.card.records.diagnosis',
            ])->findOrFail($appointmentId);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Записів не знайдено'], 404);
        }

        $this->authorize('view', $appointment);

        $specializationId = $appointment->service->specialization_id;

        $appointments = Appointment::with([
            'appointmentAnalyses.analysis',
            'appointmentServices.service',
            'cardRecords',
            'timeSheet.daySheet',
        ])
            ->join('time_sheets', 'appointments.time_sheet_id', '=', 'time_sheets.id')
            ->join('day_sheets', 'time_sheets.day_sheet_id', '=', 'day_sheets.id')
            ->where('appointments.patient_id', $appointment->patient_id)
            ->whereHas('service', function ($query) use ($specializationId) {
                $query->where('specialization_id', $specializationId);
            })
            ->where(function ($query) {
                $query->whereHas('cardRecords')
                    ->orWhereHas('appointmentAnalyses')
                    ->orWhereHas('appointmentServices');
            })
            ->orderBy('day_sheets.date', 'desc')
            ->orderBy('time_sheets.start_time', 'desc')
            ->select('appointments.*')
            ->paginate(5);

        $appointmentsData = $appointments->getCollection()->map(function ($appt) {
            return [
                'id' => $appt->id,
                'appointment_datetime' => $appt->appointment_date->format('d.m.Y') . ' ' . $appt->timeSheet->start_time . ' - ' . $appt->timeSheet->end_time,
                'records' => $appt->cardRecords->map(function ($record) {
                    return [
                        'id' => $record->id,
                        'doctor' => [
                            'first_name' => $record->doctor->user->first_name,
                            'last_name' => $record->doctor->user->last_name,
                        ],
                        'date' => $record->created_at->format('d.m.Y H:i'),
                        'medical_history' => $record->medical_history,
                        'diagnosis' => $record->diagnosis ? $record->diagnosis->name : $record->custom_diagnosis,
                        'treatment' => $record->treatment,
                    ];
                }),
                'analyses' => $appt->appointmentAnalyses->map(function ($analysis) {
                    return [
                        'id' => $analysis->id,
                        'name' => $analysis->analysis->name,
                        'price' => $analysis->price,
                        'quantity' => $analysis->quantity,
                        'total_price' => $analysis->total_price,
                        'appointment_date' => $analysis->appointment_date->format('d.m.Y'),
                        'recommended_date' => optional($analysis->recommended_date)->format('d.m.Y'),
                        'submission_date' => optional($analysis->submission_date)->format('d.m.Y'),
                        'file' => $analysis->file,
                        'status' => $analysis->status,
                    ];
                }),
                'services' => $appt->appointmentServices->map(function ($service) {
                    return [
                        'id' => $service->id,
                        'name' => $service->service->name,
                        'price' => $service->price,
                        'quantity' => $service->quantity,
                        'total_price' => $service->total_price,
                    ];
                }),
            ];
        });

        return response()->json([
            'specialization' => $appointment->service->specialization,
            'patient' => [
                'name' => $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name,
            ],
            'appointments' => $appointmentsData,
            'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
            'appointment_status' => $appointment->status,
            'pagination' => [
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
            ],
        ]);
    }

    public function updateStatus(AppointmentStatusRequest $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $validated = $request->validated();

        $appointment->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Статус успішно оновлено.', 'status' => $appointment->status]);
    }
}
