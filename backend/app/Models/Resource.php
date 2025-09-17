<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resource
 * 
 * @property int $id
 * @property string $title
 * @property string|null $type
 * @property string|null $summary
 * @property string|null $content
 * @property string|null $url
 * @property int|null $author_id
 * @property int|null $validated_by
 * @property Carbon|null $validated_at
 * @property string|null $tags
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class Resource extends Model
{
	protected $table = 'resources';

	protected $casts = [
		'author_id' => 'int',
		'validated_by' => 'int',
		'validated_at' => 'datetime'
	];

	protected $fillable = [
		'title',
		'type',
		'summary',
		'content',
		'url',
		'author_id',
		'validated_by',
		'validated_at',
		'tags'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'validated_by');
	}
}
