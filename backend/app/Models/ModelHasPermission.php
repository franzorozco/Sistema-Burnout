<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelHasPermission
 * 
 * @property int $permission_id
 * @property string $model_type
 * @property int $model_id
 *
 * @package App\Models
 */
class ModelHasPermission extends Model
{
	protected $table = 'model_has_permissions';
	protected $primaryKey = 'permission_id';
	public $timestamps = false;

	protected $casts = [
		'model_id' => 'int'
	];

	protected $fillable = [
		'model_type',
		'model_id'
	];
}
