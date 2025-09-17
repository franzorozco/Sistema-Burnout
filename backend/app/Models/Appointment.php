<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 * 
 * @property int $id
 * @property int $student_profile_id
 * @property int $professional_id
 * @property Carbon $scheduled_at
 * @property int|null $duration_minutes
 * @property string|null $status
 * @property string|null $notes
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property StudentProfile $student_profile
 * @property Professional $professional
 * @property User|null $user
 *
 * @package App\Models
 */
class Appointment extends Model
{
	protected $table = 'appointments';

	protected $casts = [
		'student_profile_id' => 'int',
		'professional_id' => 'int',
		'scheduled_at' => 'datetime',
		'duration_minutes' => 'int',
		'created_by' => 'int'
	];

	protected $fillable = [
		'student_profile_id',
		'professional_id',
		'scheduled_at',
		'duration_minutes',
		'status',
		'notes',
		'created_by'
	];

	public function student_profile()
	{
		return $this->belongsTo(StudentProfile::class);
	}

	public function professional()
	{
		return $this->belongsTo(Professional::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}
}
