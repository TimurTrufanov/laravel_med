<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentBooked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $timeSlotId;
    public $appointment;

    /**
     * Create a new event instance.
     */
    public function __construct($timeSlotId, Appointment $appointment)
    {
        $this->timeSlotId = $timeSlotId;
        $this->appointment = $appointment;
    }

    public function broadcastOn()
    {
        return new Channel('appointments');
    }

    public function broadcastWith(): array
    {
        return [
            'time_slot_id' => $this->timeSlotId,
            'appointment' => [
                'id' => $this->appointment->id,
                'patient_name' => $this->appointment->patient->user->first_name . ' ' . $this->appointment->patient->user->last_name,
                'service_name' => $this->appointment->service->name,
                'appointment_date' => $this->appointment->appointment_date,
                'start_time' => $this->appointment->timeSheet->start_time,
                'end_time' => $this->appointment->timeSheet->end_time,
                'patient_id' => $this->appointment->patient_id,
            ],
        ];
    }
}
