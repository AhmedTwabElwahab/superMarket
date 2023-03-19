<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * Class User
 * @package App\Models
 *
 * @property integer $id
 * @property string  $name
 * @property string  $username
 * @property string  $email
 * @property string  $password
 *
 * RELATIONS PROPERTIES
 * @method User paginate(int $int)
 *
 * @method static User get()
 * @method static User whereRoleIs(string $string)
 * @method static User find(int $id)
 * @method static where(...$args)
 * @method static User firstOrFail(int $id)
 * @method static User findOrFail(int $id)
 * @method static create(array $array)
 */
class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function activeUser(): User
    {
        return Auth::user();
    }

    public function cashBox(): int
    {
        return MASTER_CASH_BOX_ACCOUNT;
    }
}
