<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'analysis_id',
        'price',
        'quantity',
        'total_price',
        'appointment_date',
        'recommended_date',
        'submission_date',
        'file',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'recommended_date' => 'date',
        'submission_date' => 'date',
    ];

    public function analysis(): BelongsTo
    {
        return $this->belongsTo(Analysis::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
