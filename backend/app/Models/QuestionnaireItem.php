<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireItem
 * 
 * @property int $id
 * @property int $questionnaire_id
 * @property int $item_order
 * @property string $question_text
 * @property string $response_type
 * @property string|null $meta
 * 
 * @property Questionnaire $questionnaire
 * @property Collection|QuestionnaireChoice[] $questionnaire_choices
 *
 * @package App\Models
 */
class QuestionnaireItem extends Model
{
	protected $table = 'questionnaire_items';
	public $timestamps = false;

	protected $casts = [
		'questionnaire_id' => 'int',
		'item_order' => 'int'
	];

	protected $fillable = [
		'questionnaire_id',
		'item_order',
		'question_text',
		'response_type',
		'meta'
	];

	public function questionnaire()
	{
		return $this->belongsTo(Questionnaire::class);
	}

	public function questionnaire_choices()
	{
		return $this->hasMany(QuestionnaireChoice::class, 'item_id');
	}
}
