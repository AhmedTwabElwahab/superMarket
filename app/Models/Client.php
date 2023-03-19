<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Client
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $number
 * @property string $whatsApp
 * @property string $address
 * @property integer $account_id
 *
 * @property Account $account
 *
 * @method Client find(mixed $id)
 * @method Client[] get()
 * @method static where(...$args)
 * @method Client findOrFail(mixed $id)
 * @method static paginate(int $APP_PAGINATE)
 */
class Client extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y:m:d H:i:s';

    protected $fillable =[
        'name',
        'email',
        'phone',
        'number',
        'whatsApp',
        'address',
    ];

    public function account():HasOne
    {
        return $this->hasOne(Account::class,'id','account_id');
    }

    public function subAccount(): int
    {
        return CLIENTS_ACCOUNT;
    }


}
