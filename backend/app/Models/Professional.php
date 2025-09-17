<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Professional
 *
 * @property $id
 * @property $user_id
 * @property $profession
 * @property $license_number
 * @property $bio
 * @property $is_available
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Appointment[] $appointments
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Professional extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'profession', 'license_number', 'bio', 'is_available'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(\App\Models\Appointment::class, 'id', 'professional_id');
    }
    
}
