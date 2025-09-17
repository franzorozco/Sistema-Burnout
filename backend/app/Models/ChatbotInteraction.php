<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatbotInteraction
 *
 * @property $id
 * @property $user_id
 * @property $session_id
 * @property $input_text
 * @property $input_metadata
 * @property $response_text
 * @property $response_metadata
 * @property $intent
 * @property $sentiment
 * @property $detected_risk
 * @property $detected_keywords
 * @property $created_at
 *
 * @property User $user
 * @property ChatbotAlert[] $chatbotAlerts
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ChatbotInteraction extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'session_id', 'input_text', 'input_metadata', 'response_text', 'response_metadata', 'intent', 'sentiment', 'detected_risk', 'detected_keywords'];


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
    public function chatbotAlerts()
    {
        return $this->hasMany(\App\Models\ChatbotAlert::class, 'id', 'chatbot_interaction_id');
    }
    
}
