<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * Class Category
 * @package App\Models
 *
 * @property int    $id
 * @property String $name
 *
 * RELATIONS PROPERTIES
 * @property Product[] $products
 *
 * @method static Category get()
 * @method static find(mixed $id)
 * @method static findOrFail(mixed $id)
 * @method static where(...$args)
 * @method static paginate(int $APP_PAGINATE)
 */
class Category extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $dateFormat = 'Y-m-d H-i-s';

    protected $guarded =[];


    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'category_id','id');
    }
}
