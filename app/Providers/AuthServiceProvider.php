<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Appointment;
use App\Models\DaySheet;
use App\Models\User;
use App\Policies\Doctor\AppointmentPolicy;
use App\Policies\Doctor\DaySheetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        DaySheet::class => DaySheetPolicy::class,
        Appointment::class => AppointmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('is-doctor', function (User $user) {
            return $user->role->name === 'лікар';
        });

        Gate::define('is-patient', function (User $user) {
            return $user->role->name === 'пацієнт';
        });
    }
}
