<?php

namespace App\Policies\Doctor;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    public function create(User $user, Appointment $appointment): bool
    {
        return $user->doctor->id === $appointment->doctor_id;
    }

    public function view(User $user, Appointment $appointment): Response
    {
        return $user->doctor->id === $appointment->doctor_id
            ? Response::allow()
            : Response::deny('У вас не має прав на перегляд цих записів');
    }
}
