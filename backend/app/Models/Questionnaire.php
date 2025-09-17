<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Questionnaire
 *
 * @property $id
 * @property $code
 * @property $title
 * @property $description
 * @property $version
 * @property $created_by
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property QuestionnaireItem[] $questionnaireItems
 * @property QuestionnaireResponse[] $questionnaireResponses
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Questionnaire extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['code', 'title', 'description', 'version', 'created_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionnaireItems()
    {
        return $this->hasMany(\App\Models\QuestionnaireItem::class, 'id', 'questionnaire_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionnaireResponses()
    {
        return $this->hasMany(\App\Models\QuestionnaireResponse::class, 'id', 'questionnaire_id');
    }
    
}
