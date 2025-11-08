<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;
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
    public function item()
    {
        return $this->belongsTo(QuestionnaireItem::class, 'item_id', 'id');
    }
    
    public function questionnaireItem()
    {
        return $this->belongsTo(\App\Models\QuestionnaireItem::class, 'item_id', 'id');
    }
    
}
