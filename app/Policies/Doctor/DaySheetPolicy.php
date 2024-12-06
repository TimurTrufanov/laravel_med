<?php

namespace App\Policies\Doctor;

use App\Models\DaySheet;
use App\Models\User;

class DaySheetPolicy
{
    public function view(User $user, DaySheet $daySheet): bool
    {
        return $user->doctor && $daySheet->doctor_id === $user->doctor->id;
    }
}
