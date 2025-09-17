<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatbotAlert
 * 
 * @property int $id
 * @property int $chatbot_interaction_id
 * @property int|null $student_profile_id
 * @property string $alert_type
 * @property string $severity
 * @property Carbon|null $created_at
 * @property Carbon|null $resolved_at
 * @property int|null $resolved_by
 * @property string|null $notes
 * 
 * @property ChatbotInteraction $chatbot_interaction
 * @property StudentProfile|null $student_profile
 * @property User|null $user
 *
 * @package App\Models
 */
class ChatbotAlert extends Model
{
	protected $table = 'chatbot_alerts';
	public $timestamps = false;

	protected $casts = [
		'chatbot_interaction_id' => 'int',
		'student_profile_id' => 'int',
		'resolved_at' => 'datetime',
		'resolved_by' => 'int'
	];

	protected $fillable = [
		'chatbot_interaction_id',
		'student_profile_id',
		'alert_type',
		'severity',
		'resolved_at',
		'resolved_by',
		'notes'
	];

	public function chatbot_interaction()
	{
		return $this->belongsTo(ChatbotInteraction::class);
	}

	public function student_profile()
	{
		return $this->belongsTo(StudentProfile::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'resolved_by');
	}
}
