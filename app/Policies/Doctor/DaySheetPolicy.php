<?php

namespace App\Policies\Doctor;

use App\Models\DaySheet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DaySheetPolicy
{
    public function view(User $user, DaySheet $daySheet): Response
    {
        return $user->doctor && $daySheet->doctor_id === $user->doctor->id
            ? Response::allow()
            : Response::deny('У вас не має прав на перегляд цього розкладу');
    }
}
