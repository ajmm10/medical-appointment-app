<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_type_id',
        'allergies',
        'surgical_history',
        'family_medical_history',
        'observations',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bloodType(): BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }
}
