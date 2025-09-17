<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostTag
 * 
 * @property int $post_id
 * @property string $tag
 * 
 * @property Post $post
 *
 * @package App\Models
 */
class PostTag extends Model
{
	protected $table = 'post_tags';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'post_id' => 'int'
	];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}
}
