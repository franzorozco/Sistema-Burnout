<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostVote
 * 
 * @property int $id
 * @property int $user_id
 * @property int|null $post_id
 * @property int|null $comment_id
 * @property int $vote
 * @property Carbon|null $created_at
 * 
 * @property User $user
 * @property Post|null $post
 * @property Comment|null $comment
 *
 * @package App\Models
 */
class PostVote extends Model
{
	protected $table = 'post_votes';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'post_id' => 'int',
		'comment_id' => 'int',
		'vote' => 'int'
	];

	protected $fillable = [
		'user_id',
		'post_id',
		'comment_id',
		'vote'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function post()
	{
		return $this->belongsTo(Post::class);
	}

	public function comment()
	{
		return $this->belongsTo(Comment::class);
	}
}
