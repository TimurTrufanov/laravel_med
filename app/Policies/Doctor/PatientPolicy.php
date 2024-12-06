<?php

namespace App\Policies\Doctor;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    public function view(User $user, Patient $patient): bool
    {
        return $user->doctor && $user->doctor->id === $patient->doctor_id;
    }

    public function update(User $user, Patient $patient): bool
    {
        return $user->doctor && $user->doctor->id === $patient->doctor_id;
    }
}
