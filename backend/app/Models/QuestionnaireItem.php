<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireItem
 *
 * @property $id
 * @property $questionnaire_id
 * @property $item_order
 * @property $question_text
 * @property $response_type
 * @property $meta
 *
 * @property Questionnaire $questionnaire
 * @property QuestionnaireChoice[] $questionnaireChoices
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class QuestionnaireItem extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['questionnaire_id', 'item_order', 'question_text', 'response_type', 'meta'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaire()
    {
        return $this->belongsTo(\App\Models\Questionnaire::class, 'questionnaire_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionnaireChoices()
    {
        return $this->hasMany(\App\Models\QuestionnaireChoice::class, 'id', 'item_id');
    }
    
}
