<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuditLog
 * 
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string|null $table_name
 * @property string|null $record_id
 * @property string|null $old_data
 * @property string|null $new_data
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class AuditLog extends Model
{
	protected $table = 'audit_logs';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'action',
		'table_name',
		'record_id',
		'old_data',
		'new_data',
		'ip_address',
		'user_agent'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
