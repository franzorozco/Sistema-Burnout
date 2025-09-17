<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 *
 * @property $id
 * @property $owner_user_id
 * @property $related_type
 * @property $related_id
 * @property $filename
 * @property $url
 * @property $mime_type
 * @property $size_bytes
 * @property $checksum
 * @property $created_at
 *
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class File extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['owner_user_id', 'related_type', 'related_id', 'filename', 'url', 'mime_type', 'size_bytes', 'checksum'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'owner_user_id', 'id');
    }
    
}
