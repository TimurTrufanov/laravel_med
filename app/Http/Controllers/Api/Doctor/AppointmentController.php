<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctor\AppointmentAnalysisRequest;
use App\Http\Requests\Api\Doctor\AppointmentServiceRequest;
use App\Models\Analysis;
use App\Models\Appointment;
use App\Models\Card;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function addAppointmentDetails(Request $request, $appointmentId)
    {
        DB::beginTransaction();

        try {
            $appointment = Appointment::with('service.specialization')->findOrFail($appointmentId);

            $card = Card::firstOrCreate([
                'patient_id' => $appointment->patient_id,
                'specialization_id' => $appointment->service->specialization_id,
            ]);

            $record = $card->records()->create([
                'doctor_id' => $request->user()->doctor->id,
                'appointment_id' => $appointment->id,
                'medical_history' => $request->medical_history,
                'diagnosis_id' => $request->diagnosis_id,
                'custom_diagnosis' => $request->custom_diagnosis,
                'treatment' => $request->treatment,
            ]);

            if ($request->filled('analyses')) {
                foreach ($request->analyses as $analysisData) {
                    $analysisRequest = new AppointmentAnalysisRequest();
                    $analysisRequest->replace($analysisData);
                    $this->validate($analysisRequest, $analysisRequest->rules(), $analysisRequest->messages());

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
            }

            if ($request->filled('services')) {
                foreach ($request->services as $serviceData) {
                    $serviceRequest = new AppointmentServiceRequest();
                    $serviceRequest->replace($serviceData);
                    $this->validate($serviceRequest, $serviceRequest->rules(), $serviceRequest->messages());

                    $service = Service::findOrFail($serviceData['service_id']);

                    $appointment->appointmentServices()->create([
                        'service_id' => $service->id,
                        'price' => $service->price,
                        'quantity' => $serviceData['quantity'],
                        'total_price' => $service->price * $serviceData['quantity'],
                    ]);
                }
            }

            DB::commit();

            $record->load('doctor.user');

            return response()->json([
                'record' => $record,
                'message' => 'Запис успішно додано.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'errors' => [
                    'general' => [$e->getMessage()],
                ],
            ], 422);
        }
    }

    public function getAppointmentDetails($appointmentId)
    {
        $appointment = Appointment::with([
            'patient.user',
            'service.specialization',
            'appointmentAnalyses.analysis',
            'appointmentServices.service',
            'cardRecords.card.records.diagnosis',
        ])->findOrFail($appointmentId);

        // Найти все приёмы пациента с этой специализацией
        $specializationId = $appointment->service->specialization_id;
        $appointments = Appointment::with([
            'appointmentAnalyses.analysis',
            'appointmentServices.service',
            'cardRecords',
        ])->where('patient_id', $appointment->patient_id)
            ->whereHas('service', function ($query) use ($specializationId) {
                $query->where('specialization_id', $specializationId);
            })->get();

        $appointmentsData = $appointments->map(function ($appt) {
            return [
                'id' => $appt->id,
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
            'patient' => $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name,
            'appointments' => $appointmentsData,
        ]);
    }
}
