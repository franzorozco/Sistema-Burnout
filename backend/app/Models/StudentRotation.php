<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentRotation
 * 
 * @property int $id
 * @property int $student_profile_id
 * @property int $rotation_id
 * @property Carbon|null $assigned_at
 * @property string|null $shift_type
 * @property string|null $notes
 * 
 * @property StudentProfile $student_profile
 * @property Rotation $rotation
 *
 * @package App\Models
 */
class StudentRotation extends Model
{
	protected $table = 'student_rotation';
	public $timestamps = false;

	protected $casts = [
		'student_profile_id' => 'int',
		'rotation_id' => 'int',
		'assigned_at' => 'datetime'
	];

	protected $fillable = [
		'student_profile_id',
		'rotation_id',
		'assigned_at',
		'shift_type',
		'notes'
	];

	public function student_profile()
	{
		return $this->belongsTo(StudentProfile::class);
	}

	public function rotation()
	{
		return $this->belongsTo(Rotation::class);
	}
}
