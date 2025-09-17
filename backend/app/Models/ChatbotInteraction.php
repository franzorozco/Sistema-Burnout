<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChatbotInteraction
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property string|null $input_text
 * @property string|null $input_metadata
 * @property string|null $response_text
 * @property string|null $response_metadata
 * @property string|null $intent
 * @property string|null $sentiment
 * @property bool|null $detected_risk
 * @property string|null $detected_keywords
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 * @property Collection|ChatbotAlert[] $chatbot_alerts
 *
 * @package App\Models
 */
class ChatbotInteraction extends Model
{
	protected $table = 'chatbot_interactions';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'detected_risk' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'session_id',
		'input_text',
		'input_metadata',
		'response_text',
		'response_metadata',
		'intent',
		'sentiment',
		'detected_risk',
		'detected_keywords'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function chatbot_alerts()
	{
		return $this->hasMany(ChatbotAlert::class);
	}
}
