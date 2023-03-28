<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Account
 * @package App\Models
 *
 * @property integer $id
 * @property string  $company_name
 * @property string $address
 * @property string $phone
 * @property string $whatsApp
 * @property string $currency
 * @property string $company_logo
 *
 * RELATIONS PROPERTIES
 *
 *
 *
 */
class AppInfo extends Model
{
    use HasFactory;
    protected $table = 'app_info';
}
