<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 *
 * @property $id
 * @property $post_id
 * @property $user_id
 * @property $parent_comment_id
 * @property $body
 * @property $score
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Post $post
 * @property User $user
 * @property Comment $comment
 * @property Comment[] $comments
 * @property PostVote[] $postVotes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['post_id', 'user_id', 'parent_comment_id', 'body', 'score'];


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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(\App\Models\Comment::class, 'parent_comment_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class, 'id', 'parent_comment_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postVotes()
    {
        return $this->hasMany(\App\Models\PostVote::class, 'id', 'comment_id');
    }
    
}
