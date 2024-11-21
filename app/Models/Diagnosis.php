<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function cardRecords(): HasMany
    {
        return $this->hasMany(CardRecord::class);
    }
}
