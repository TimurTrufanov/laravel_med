<?php

namespace App\Services;

use App\Events\AppointmentBooked;
use App\Jobs\Patient\SendAppointmentMail;
use App\Models\Analysis;
use App\Models\Appointment;
use App\Models\Card;
use App\Models\Service;
use App\Models\TimeSheet;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function getAppointments($patientId, $specializationId)
    {
        return Appointment::with([
            'appointmentAnalyses.analysis',
            'appointmentServices.service',
            'cardRecords',
            'timeSheet.daySheet',
        ])
            ->join('time_sheets', 'appointments.time_sheet_id', '=', 'time_sheets.id')
            ->join('day_sheets', 'time_sheets.day_sheet_id', '=', 'day_sheets.id')
            ->where('appointments.patient_id', $patientId)
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
    }

    public function addDetails($appointment, $request)
    {
        DB::beginTransaction();

        try {
            $card = Card::firstOrCreate([
                'patient_id' => $appointment->patient_id,
                'specialization_id' => $appointment->service->specialization_id,
            ]);

            $this->createCardRecord($request, $card, $appointment);
            $this->createAppointmentAnalyses($request, $appointment);
            $this->createAppointmentServices($request, $appointment);

            DB::commit();

            return ['message' => 'Запис успішно додано.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['errors' => ['general' => [$e->getMessage()]]];
        }
    }

    public function createAppointment($user, $validated)
    {
        DB::beginTransaction();

        try {
            $timeSheet = TimeSheet::with('daySheet')->findOrFail($validated['time_sheet_id']);

            if (!$timeSheet->is_active) {
                return ['errors' => ['general' => ['Даний слот вже зайнято']]];
            }

            $appointment = Appointment::create([
                'time_sheet_id' => $timeSheet->id,
                'patient_id' => $user->patient->id,
                'doctor_id' => $timeSheet->daySheet->doctor_id,
                'clinic_id' => $timeSheet->daySheet->clinic_id,
                'appointment_date' => $timeSheet->daySheet->date,
                'service_id' => $validated['service_id'],
            ]);

            $timeSheet->update(['is_active' => false]);

            broadcast(new AppointmentBooked($timeSheet->id, $appointment))->toOthers();
            SendAppointmentMail::dispatch($user->email, $appointment);

            DB::commit();

            return ['appointment' => $appointment];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['errors' => ['general' => [$e->getMessage()]]];
        }
    }

    private function createCardRecord($request, $card, $appointment)
    {
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
    }

    private function createAppointmentAnalyses($request, $appointment)
    {
        collect($request->analyses)->each(function ($analysisData) use ($appointment) {
            $analysis = Analysis::findOrFail($analysisData['analysis_id']);
            $appointment->appointmentAnalyses()->create([
                'analysis_id' => $analysis->id,
                'price' => $analysis->price,
                'quantity' => $analysisData['quantity'],
                'total_price' => $analysis->price * $analysisData['quantity'],
                'appointment_date' => now(),
                'recommended_date' => $analysisData['recommended_date'] ?? null,
            ]);
        });
    }

    private function createAppointmentServices($request, $appointment)
    {
        collect($request->services)->each(function ($serviceData) use ($appointment) {
            $service = Service::findOrFail($serviceData['service_id']);
            $appointment->appointmentServices()->create([
                'service_id' => $service->id,
                'price' => $service->price,
                'quantity' => $serviceData['quantity'],
                'total_price' => $service->price * $serviceData['quantity'],
            ]);
        });
    }
}
