<?php

namespace App\Models;

use App\Http\Requests\ProductRequest;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\HasOne;



/**
 * Class Product
 * @package App\Models
 *
 * @property integer $id
 * @property string  $name
 * @property integer $unit_id
 * @property integer $purchase_price
 * @property integer $sale_price
 * @property integer $wholesale_price
 * @property integer $half_price
 *
 * RELATIONS PROPERTIES
 *
 * @property Stock       $stock
 * @property Barcode     $barcode
 * @property unit        $unit
 * @property Category    $category
 *
 *
 * @method static Product paginate(int $int)
 * @method static Product findOrFail(int $id)
 * @method static Product find(int $id)
 * @method static Product where(...$args)
 */
class Product extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $guarded = [];

    /**
     * @throws Exception
     */
    public static function createProduct(ProductRequest $request): Product
    {
        $product = new self($request->except('barcode'));

        if ($product->save() == false)
        {
            throw new Exception('error_create_product',APP_ERROR);
        }
        return $product;
    }

    /**
     * @param int $price
     * @return bool
     * @throws Exception
     */
    public function updateSalePrice(int $price): bool
    {
        if ($price != null || $price != 0)
        {
            $this->sale_price = $price;
        }
        if ($this->save() == false)
        {
            throw new Exception('update_sale_price_faill',APP_ERROR);
        }
        return true;
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class,'id','unit_id');
    }

    public function barcode(): HasMany
    {
        return $this->hasMany(Barcode::class,'product_id','id');
    }

    public function stockCustom(int $warehouseID)
    {
        return Stock::where('warehouse_id',$warehouseID)->where('product_id',$this->id)->first();
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class,'product_id','id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public static function getProduct(Request $request)
    {
        if ($request->has('product_id'))
        {
            $stock  = Stock::where('product_id',$request->input('product_id'))->where('warehouse_id',$request->input('warehouse_id'))->get();

            $product = Product::where('id',$request->input('product_id'))->with(['unit','barcode'])->get();
            return ['stock' => $stock, 'product' => $product];
        }
//        if ($request->has('barcode'))
//        {
//            return Product::where('barcode' ,$request->barcode)->with(['unit'])->get();
//        }
        return false;
    }
}
