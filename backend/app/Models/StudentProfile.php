<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentProfile
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $student_code
 * @property Carbon|null $birthdate
 * @property string|null $career
 * @property int|null $semester
 * @property string|null $group_name
 * @property bool $consent_given
 * @property Carbon|null $consent_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Appointment[] $appointments
 * @property Collection|ChatbotAlert[] $chatbot_alerts
 * @property Collection|QuestionnaireResponse[] $questionnaire_responses
 * @property Collection|StateReport[] $state_reports
 * @property Collection|StudentRotation[] $student_rotations
 *
 * @package App\Models
 */
class StudentProfile extends Model
{
	protected $table = 'student_profiles';

	protected $casts = [
		'user_id' => 'int',
		'birthdate' => 'datetime',
		'semester' => 'int',
		'consent_given' => 'bool',
		'consent_at' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'student_code',
		'birthdate',
		'career',
		'semester',
		'group_name',
		'consent_given',
		'consent_at'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function appointments()
	{
		return $this->hasMany(Appointment::class);
	}

	public function chatbot_alerts()
	{
		return $this->hasMany(ChatbotAlert::class);
	}

	public function questionnaire_responses()
	{
		return $this->hasMany(QuestionnaireResponse::class);
	}

	public function state_reports()
	{
		return $this->hasMany(StateReport::class);
	}

	public function student_rotations()
	{
		return $this->hasMany(StudentRotation::class);
	}
}
