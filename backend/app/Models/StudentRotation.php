<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentRotation
 *
 * @property $id
 * @property $student_profile_id
 * @property $rotation_id
 * @property $assigned_at
 * @property $shift_type
 * @property $notes
 *
 * @property StudentProfile $studentProfile
 * @property Rotation $rotation
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class StudentRotation extends Model
{

    protected $table = 'student_rotation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['student_profile_id', 'rotation_id', 'assigned_at', 'shift_type', 'notes'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentProfile()
    {
        return $this->belongsTo(\App\Models\StudentProfile::class, 'student_profile_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rotation()
    {
        return $this->belongsTo(\App\Models\Rotation::class, 'rotation_id', 'id');
    }
    
}
