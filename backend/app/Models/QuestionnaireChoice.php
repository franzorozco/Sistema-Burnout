<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireChoice
 *
 * @property $id
 * @property $item_id
 * @property $choice_order
 * @property $value
 * @property $label
 *
 * @property QuestionnaireItem $questionnaireItem
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class QuestionnaireChoice extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['item_id', 'choice_order', 'value', 'label'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionnaireItem()
    {
        return $this->belongsTo(\App\Models\QuestionnaireItem::class, 'item_id', 'id');
    }
    
}
