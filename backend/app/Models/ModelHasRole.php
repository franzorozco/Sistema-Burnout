<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelHasRole
 * 
 * @property int $role_id
 * @property string $model_type
 * @property int $model_id
 * @property int|null $assigned_by
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class ModelHasRole extends Model
{
	protected $table = 'model_has_roles';
	protected $primaryKey = 'role_id';
	public $timestamps = false;

	protected $casts = [
		'model_id' => 'int',
		'assigned_by' => 'int'
	];

	protected $fillable = [
		'model_type',
		'model_id',
		'assigned_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'assigned_by');
	}
}
