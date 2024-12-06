<?php

namespace App\Http\Controllers\Api\Patient;

use App\Events\AppointmentBooked;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Patient\AppointmentRequest;
use App\Models\Appointment;
use App\Models\TimeSheet;

class AppointmentController extends Controller
{
    public function createAppointment(AppointmentRequest $request)
    {
        $validated = $request->validated();

        $timeSheet = TimeSheet::with('daySheet')->findOrFail($validated['time_sheet_id']);

        if (!$timeSheet->is_active) {
            return response()->json(['message' => 'Даний слот вже зайнято'], 400);
        }

        $appointment = Appointment::create([
            'time_sheet_id' => $timeSheet->id,
            'patient_id' => $request->user()->patient->id,
            'doctor_id' => $timeSheet->daySheet->doctor_id,
            'appointment_date' => $timeSheet->daySheet->date,
            'service_id' => $validated['service_id'],
        ]);

        $timeSheet->update(['is_active' => false]);

        broadcast(new AppointmentBooked($timeSheet->id, $appointment))->toOthers();

        return response()->json(['message' => 'Ви успішно записались на прийом', 'appointment' => $appointment], 201);
    }
}
