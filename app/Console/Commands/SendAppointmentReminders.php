<?php

namespace App\Console\Commands;

use App\Mail\Patient\AppointmentReminderMail;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-appointment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Відправляє нагадування пацієнтам у день прийому';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $appointments = Appointment::where('appointment_date', $today)
            ->whereNull('reminder_sent_at')
            ->get();

        foreach ($appointments as $appointment) {
            Mail::to($appointment->patient->user->email)
                ->queue(new AppointmentReminderMail($appointment));

            $appointment->update(['reminder_sent_at' => now()]);
        }

        $this->info('Нагадування успішно надіслано.');
    }
}
