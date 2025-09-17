<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StateReport
 * 
 * @property int $id
 * @property int $student_profile_id
 * @property Carbon $report_date
 * @property string|null $mood
 * @property int|null $energy_level
 * @property float|null $sleep_hours
 * @property int|null $stress_score
 * @property string|null $symptoms
 * @property string|null $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property StudentProfile $student_profile
 *
 * @package App\Models
 */
class StateReport extends Model
{
	protected $table = 'state_reports';

	protected $casts = [
		'student_profile_id' => 'int',
		'report_date' => 'datetime',
		'energy_level' => 'int',
		'sleep_hours' => 'float',
		'stress_score' => 'int'
	];

	protected $fillable = [
		'student_profile_id',
		'report_date',
		'mood',
		'energy_level',
		'sleep_hours',
		'stress_score',
		'symptoms',
		'location'
	];

	public function student_profile()
	{
		return $this->belongsTo(StudentProfile::class);
	}
}
