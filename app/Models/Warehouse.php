<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Warehouse
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @method static paginate(int $APP_PAGINATE)
 */
class Warehouse extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y:m:d H:i:s';

    protected $fillable =[
        'name',
        'address',
    ];


}
