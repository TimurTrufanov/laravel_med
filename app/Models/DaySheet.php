<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DaySheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'clinic_id',
        'date',
        'start_time',
        'end_time',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function timeSheets(): HasMany
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function getStartTimeAttribute($value): string
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getEndTimeAttribute($value): string
    {
        return Carbon::parse($value)->format('H:i');
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('d F Y');
    }
}
