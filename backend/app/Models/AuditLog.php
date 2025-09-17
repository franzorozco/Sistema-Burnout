<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuditLog
 *
 * @property $id
 * @property $user_id
 * @property $action
 * @property $table_name
 * @property $record_id
 * @property $old_data
 * @property $new_data
 * @property $ip_address
 * @property $user_agent
 * @property $created_at
 *
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AuditLog extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'action', 'table_name', 'record_id', 'old_data', 'new_data', 'ip_address', 'user_agent'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
