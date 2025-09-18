<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Resource
 *
 * @property $id
 * @property $title
 * @property $type
 * @property $summary
 * @property $content
 * @property $url
 * @property $author_id
 * @property $validated_by
 * @property $validated_at
 * @property $tags
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Resource extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'type', 'summary', 'content', 'url', 'author_id', 'validated_by', 'validated_at', 'tags'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id', 'id');
    }
    
    
}
