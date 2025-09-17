<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StateReport
 *
 * @property $id
 * @property $student_profile_id
 * @property $report_date
 * @property $mood
 * @property $energy_level
 * @property $sleep_hours
 * @property $stress_score
 * @property $symptoms
 * @property $location
 * @property $created_at
 * @property $updated_at
 *
 * @property StudentProfile $studentProfile
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class StateReport extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['student_profile_id', 'report_date', 'mood', 'energy_level', 'sleep_hours', 'stress_score', 'symptoms', 'location'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentProfile()
    {
        return $this->belongsTo(\App\Models\StudentProfile::class, 'student_profile_id', 'id');
    }
    
}
