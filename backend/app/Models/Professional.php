<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Professional
 * 
 * @property int $id
 * @property int $user_id
 * @property string $profession
 * @property string|null $license_number
 * @property string|null $bio
 * @property bool|null $is_available
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Appointment[] $appointments
 *
 * @package App\Models
 */
class Professional extends Model
{
	protected $table = 'professionals';

	protected $casts = [
		'user_id' => 'int',
		'is_available' => 'bool'
	];

	protected $fillable = [
		'user_id',
		'profession',
		'license_number',
		'bio',
		'is_available'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function appointments()
	{
		return $this->hasMany(Appointment::class);
	}
}
