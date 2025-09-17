<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentProfile
 *
 * @property $id
 * @property $user_id
 * @property $student_code
 * @property $birthdate
 * @property $career
 * @property $semester
 * @property $group_name
 * @property $consent_given
 * @property $consent_at
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Appointment[] $appointments
 * @property ChatbotAlert[] $chatbotAlerts
 * @property QuestionnaireResponse[] $questionnaireResponses
 * @property StateReport[] $stateReports
 * @property StudentRotation[] $studentRotations
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class StudentProfile extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'student_code', 'birthdate', 'career', 'semester', 'group_name', 'consent_given', 'consent_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'id', 'student_profile_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chatbotAlerts()
    {
        return $this->hasMany(\App\Models\ChatbotAlert::class, 'id', 'student_profile_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionnaireResponses()
    {
        return $this->hasMany(\App\Models\QuestionnaireResponse::class, 'id', 'student_profile_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stateReports()
    {
        return $this->hasMany(\App\Models\StateReport::class, 'id', 'student_profile_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentRotations()
    {
        return $this->hasMany(\App\Models\StudentRotation::class, 'id', 'student_profile_id');
    }
    
}
