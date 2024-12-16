<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Doctor\AppointmentRequest;
use App\Http\Requests\Api\Doctor\AppointmentStatusRequest;
use App\Http\Resources\AppointmentWithRecordsResource;
use App\Http\Resources\CurrentAppointmentResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function addDetails(AppointmentRequest $request, AppointmentService $appointmentService, $appointmentId)
    {
        $appointment = Appointment::with('service.specialization')->findOrFail($appointmentId);

        $this->authorize('create', $appointment);

        $result = $appointmentService->addDetails($appointment, $request);

        if (isset($result['errors'])) {
            return response()->json($result, 422);
        }

        return response()->json($result);
    }

    public function getDetails($appointmentId, AppointmentService $appointmentService)
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

        $appointments = $appointmentService->getAppointments($appointment->patient_id, $appointment->service->specialization_id);

        return response()->json([
            'appointments' => AppointmentWithRecordsResource::collection($appointments),
            'current_appointment' => new CurrentAppointmentResource($appointment),
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
