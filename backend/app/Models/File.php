<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * 
 * @property int $id
 * @property int|null $owner_user_id
 * @property string|null $related_type
 * @property int|null $related_id
 * @property string $filename
 * @property string $url
 * @property string|null $mime_type
 * @property int|null $size_bytes
 * @property string|null $checksum
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class File extends Model
{
	protected $table = 'files';
	public $timestamps = false;

	protected $casts = [
		'owner_user_id' => 'int',
		'related_id' => 'int',
		'size_bytes' => 'int'
	];

	protected $fillable = [
		'owner_user_id',
		'related_type',
		'related_id',
		'filename',
		'url',
		'mime_type',
		'size_bytes',
		'checksum'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'owner_user_id');
	}
}
