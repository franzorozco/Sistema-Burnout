<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireResponse
 * 
 * @property int $id
 * @property int $questionnaire_id
 * @property int|null $student_profile_id
 * @property int|null $user_id
 * @property Carbon|null $submitted_at
 * @property float|null $summary_score
 * @property string|null $raw
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Questionnaire $questionnaire
 * @property StudentProfile|null $student_profile
 * @property User|null $user
 *
 * @package App\Models
 */
class QuestionnaireResponse extends Model
{
	protected $table = 'questionnaire_responses';

	protected $casts = [
		'questionnaire_id' => 'int',
		'student_profile_id' => 'int',
		'user_id' => 'int',
		'submitted_at' => 'datetime',
		'summary_score' => 'float'
	];

	protected $fillable = [
		'questionnaire_id',
		'student_profile_id',
		'user_id',
		'submitted_at',
		'summary_score',
		'raw'
	];

	public function questionnaire()
	{
		return $this->belongsTo(Questionnaire::class);
	}

	public function student_profile()
	{
		return $this->belongsTo(StudentProfile::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
