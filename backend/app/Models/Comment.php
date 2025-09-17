<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment
 * 
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property int|null $parent_comment_id
 * @property string $body
 * @property int|null $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Post $post
 * @property User $user
 * @property Comment|null $comment
 * @property Collection|Comment[] $comments
 * @property Collection|PostVote[] $post_votes
 *
 * @package App\Models
 */
class Comment extends Model
{
	use SoftDeletes;
	protected $table = 'comments';

	protected $casts = [
		'post_id' => 'int',
		'user_id' => 'int',
		'parent_comment_id' => 'int',
		'score' => 'int'
	];

	protected $fillable = [
		'post_id',
		'user_id',
		'parent_comment_id',
		'body',
		'score'
	];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comment()
	{
		return $this->belongsTo(Comment::class, 'parent_comment_id');
	}

	public function comments()
	{
		return $this->hasMany(Comment::class, 'parent_comment_id');
	}

	public function post_votes()
	{
		return $this->hasMany(PostVote::class);
	}
}
