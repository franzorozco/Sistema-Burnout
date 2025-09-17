<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 *
 * @property $id
 * @property $email
 * @property $password
 * @property $name
 * @property $paternal_surname
 * @property $maternal_surname
 * @property $phone
 * @property $address
 * @property $is_active
 * @property $last_login_at
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'paternal_surname',
        'maternal_surname',
        'phone',
        'address',
        'is_active',
        'password',
    ];


}
