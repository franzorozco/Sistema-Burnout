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
 * Class Post
 * 
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property bool|null $is_anonymous
 * @property int|null $score
 * @property int|null $views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property User $user
 * @property Collection|Comment[] $comments
 * @property Collection|PostTag[] $post_tags
 * @property Collection|PostVote[] $post_votes
 *
 * @package App\Models
 */
class Post extends Model
{
	use SoftDeletes;
	protected $table = 'posts';

	protected $casts = [
		'user_id' => 'int',
		'is_anonymous' => 'bool',
		'score' => 'int',
		'views' => 'int'
	];

	protected $fillable = [
		'user_id',
		'title',
		'body',
		'is_anonymous',
		'score',
		'views'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function post_tags()
	{
		return $this->hasMany(PostTag::class);
	}

	public function post_votes()
	{
		return $this->hasMany(PostVote::class);
	}
}
