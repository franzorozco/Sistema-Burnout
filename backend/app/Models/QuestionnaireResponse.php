<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireResponse
 *
 * @property $id
 * @property $questionnaire_id
 * @property $student_profile_id
 * @property $user_id
 * @property $submitted_at
 * @property $summary_score
 * @property $raw
 * @property $created_at
 * @property $updated_at
 *
 * @property Questionnaire $questionnaire
 * @property StudentProfile $studentProfile
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class QuestionnaireResponse extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['questionnaire_id', 'student_profile_id', 'user_id', 'submitted_at', 'summary_score', 'raw'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaire()
    {
        return $this->belongsTo(\App\Models\Questionnaire::class, 'questionnaire_id', 'id');
    }
    
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
