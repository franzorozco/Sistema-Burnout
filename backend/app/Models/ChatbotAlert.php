<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatbotAlert
 *
 * @property $id
 * @property $chatbot_interaction_id
 * @property $student_profile_id
 * @property $alert_type
 * @property $severity
 * @property $created_at
 * @property $resolved_at
 * @property $resolved_by
 * @property $notes
 *
 * @property ChatbotInteraction $chatbotInteraction
 * @property StudentProfile $studentProfile
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ChatbotAlert extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['chatbot_interaction_id', 'student_profile_id', 'alert_type', 'severity', 'resolved_at', 'resolved_by', 'notes'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chatbotInteraction()
    {
        return $this->belongsTo(\App\Models\ChatbotInteraction::class, 'chatbot_interaction_id', 'id');
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
        return $this->belongsTo(\App\Models\User::class, 'resolved_by', 'id');
    }
    
}
