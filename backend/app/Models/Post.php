<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 *
 * @property $id
 * @property $user_id
 * @property $title
 * @property $body
 * @property $is_anonymous
 * @property $score
 * @property $views
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property User $user
 * @property Comment[] $comments
 * @property PostTag[] $postTags
 * @property PostVote[] $postVotes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Post extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'title', 'body', 'is_anonymous', 'score', 'views'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'id', 'post_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postTags()
    {
        return $this->hasMany(\App\Models\PostTag::class, 'id', 'post_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postVotes()
    {
        return $this->hasMany(\App\Models\PostVote::class, 'id', 'post_id');
    }
    
}
