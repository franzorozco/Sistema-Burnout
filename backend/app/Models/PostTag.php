<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostTag
 *
 * @property $post_id
 * @property $tag
 *
 * @property Post $post
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostTag extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['post_id', 'tag'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class, 'post_id', 'id');
    }
    
}
