<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 *
 * @property $id
 * @property $student_profile_id
 * @property $professional_id
 * @property $scheduled_at
 * @property $duration_minutes
 * @property $status
 * @property $notes
 * @property $created_by
 * @property $created_at
 * @property $updated_at
 *
 * @property StudentProfile $studentProfile
 * @property Professional $professional
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Appointment extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['student_profile_id', 'professional_id', 'scheduled_at', 'duration_minutes', 'status', 'notes', 'created_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentProfile()
    {
        return $this->belongsTo(\App\Models\StudentProfile::class, 'student_profile_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professional()
    {
        return $this->belongsTo(\App\Models\Professional::class, 'professional_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
    
}
