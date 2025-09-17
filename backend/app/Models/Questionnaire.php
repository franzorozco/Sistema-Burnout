<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Questionnaire
 * 
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string|null $description
 * @property string|null $version
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|QuestionnaireItem[] $questionnaire_items
 * @property Collection|QuestionnaireResponse[] $questionnaire_responses
 *
 * @package App\Models
 */
class Questionnaire extends Model
{
	protected $table = 'questionnaires';

	protected $casts = [
		'created_by' => 'int'
	];

	protected $fillable = [
		'code',
		'title',
		'description',
		'version',
		'created_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function questionnaire_items()
	{
		return $this->hasMany(QuestionnaireItem::class);
	}

	public function questionnaire_responses()
	{
		return $this->hasMany(QuestionnaireResponse::class);
	}
}
