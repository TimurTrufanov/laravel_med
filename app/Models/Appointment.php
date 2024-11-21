<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'time_sheet_id',
        'appointment_date',
        'status'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function timeSheet(): BelongsTo
    {
        return $this->belongsTo(TimeSheet::class);
    }

    public function analyses(): BelongsToMany
    {
        return $this->belongsToMany(Analysis::class)->withPivot('status');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function cardRecords(): HasMany
    {
        return $this->hasMany(CardRecord::class);
    }
}
