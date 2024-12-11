<?php

namespace App\Jobs\Patient;

use App\Mail\Patient\AppointmentBookedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAppointmentMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $appointment;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $appointment)
    {
        $this->email = $email;
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new AppointmentBookedMail($this->appointment));
    }
}
