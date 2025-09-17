<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostVote
 *
 * @property $id
 * @property $user_id
 * @property $post_id
 * @property $comment_id
 * @property $vote
 * @property $created_at
 *
 * @property User $user
 * @property Post $post
 * @property Comment $comment
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostVote extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'post_id', 'comment_id', 'vote'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class, 'post_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(\App\Models\Comment::class, 'comment_id', 'id');
    }
    
}
