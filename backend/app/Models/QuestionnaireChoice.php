<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireChoice
 * 
 * @property int $id
 * @property int $item_id
 * @property int $choice_order
 * @property string|null $value
 * @property string|null $label
 * 
 * @property QuestionnaireItem $questionnaire_item
 *
 * @package App\Models
 */
class QuestionnaireChoice extends Model
{
	protected $table = 'questionnaire_choices';
	public $timestamps = false;

	protected $casts = [
		'item_id' => 'int',
		'choice_order' => 'int'
	];

	protected $fillable = [
		'item_id',
		'choice_order',
		'value',
		'label'
	];

	public function questionnaire_item()
	{
		return $this->belongsTo(QuestionnaireItem::class, 'item_id');
	}
}
