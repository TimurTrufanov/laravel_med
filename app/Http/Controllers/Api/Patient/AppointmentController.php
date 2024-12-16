<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Patient\AppointmentRequest;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    public function createAppointment(AppointmentRequest $request, AppointmentService $appointmentService)
    {
        $validated = $request->validated();

        $result = $appointmentService->createAppointment($request->user(), $validated);

        if (isset($result['errors'])) {
            return response()->json($result, 400);
        }

        return response()->json([
            'message' => 'Ви успішно записались на прийом',
            'appointment' => $result['appointment'],
        ], 201);
    }
}
