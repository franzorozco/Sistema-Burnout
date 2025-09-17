<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rotation
 * 
 * @property int $id
 * @property string $name
 * @property string|null $location
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property bool|null $is_rural
 * @property string|null $details
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|StudentRotation[] $student_rotations
 *
 * @package App\Models
 */
class Rotation extends Model
{
	protected $table = 'rotations';

	protected $casts = [
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'is_rural' => 'bool'
	];

	protected $fillable = [
		'name',
		'location',
		'start_date',
		'end_date',
		'is_rural',
		'details'
	];

	public function student_rotations()
	{
		return $this->hasMany(StudentRotation::class);
	}
}
