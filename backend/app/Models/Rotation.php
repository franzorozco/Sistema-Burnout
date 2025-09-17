<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rotation
 *
 * @property $id
 * @property $name
 * @property $location
 * @property $start_date
 * @property $end_date
 * @property $is_rural
 * @property $details
 * @property $created_at
 * @property $updated_at
 *
 * @property StudentRotation[] $studentRotations
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Rotation extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'location', 'start_date', 'end_date', 'is_rural', 'details'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentRotations()
    {
        return $this->hasMany(\App\Models\StudentRotation::class, 'id', 'rotation_id');
    }
    
}
