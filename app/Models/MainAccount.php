<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class MainAccount
 * @package App\Models
 *
 * @property integer $id
 * @property integer $type_id
 * @property string  $name
 */
class MainAccount extends Model
{
    use HasFactory;
}
