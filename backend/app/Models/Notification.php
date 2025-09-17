<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property $id
 * @property $user_id
 * @property $type
 * @property $payload
 * @property $is_read
 * @property $created_at
 *
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Notification extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'type', 'payload', 'is_read'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
