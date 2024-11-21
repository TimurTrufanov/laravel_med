<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TimeSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_sheet_id',
        'start_time',
        'end_time',
        'is_active'
    ];

    public function daySheet(): BelongsTo
    {
        return $this->belongsTo(DaySheet::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function getStartTimeAttribute($value): string
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getEndTimeAttribute($value): string
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }
}
