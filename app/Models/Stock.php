<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 * Class Stock
 * @package App\Models
 *
 * @property integer  $id
 * @property integer  $product_id
 * @property integer  $warehouse_id
 * @property integer  $beginning_inventory
 * @property integer  $sold_quantity
 * @property integer  $sales_returns
 * @property integer  $purchases_returns
 * @property integer  $purchases_quantity
 * @property integer  $available
 *
 * @property Product $product
 *
 * @method static select(string $string)
 * @method static where(...$args)
 * @method static find(int $int)
 */
class Stock extends Model
{
    use HasFactory;

    /**
     * @param int $amount
     * @param int $type
     * @param int $IN_OUT
     * @return bool
     * @throws Exception
     */
    public function updateStock(int $amount , int $type,int $IN_OUT): bool
    {
        if ($type == SALES_INVOICE)
        {
            if ($IN_OUT == STOCK_OUT)
            {
                $this->sold_quantity          += $amount;
            }
            else
            {
               $this->sold_quantity          -= $amount;
            }
        }
        elseif ($type == PURCHASE_INVOICE)
        {
            if ($IN_OUT == STOCK_IN)
            {
                $this->purchases_quantity    += $amount;
            }
            else
            {
                $this->purchases_quantity    -= $amount;
            }
        }
        elseif ($type == SALES_RETURN)
        {
            if(( $this->sales_returns + $amount ) >=  $this->sold_quantity)
            {
                throw new Exception('error_update_Stock',APP_ERROR);
            }
            if ($IN_OUT == STOCK_IN)
            {
                $this->sales_returns         += $amount;
            }
            else
            {
                $this->sales_returns         -= $amount;
            }
        }
        elseif ($type == PURCHASE_RETURN)
        {
            if ($IN_OUT == STOCK_OUT)
            {
                $this->purchases_returns     += $amount;
            }
            else
            {
                $this->purchases_returns     -= $amount;
            }
        }
        elseif ($type == OPENING_BALANCE)
        {
            $this->beginning_inventory       = $amount;
        }

        $this->available = ($this->beginning_inventory + $this->purchases_quantity + $this->sales_returns) - ($this->sold_quantity + $this->purchases_returns);

        if ($this->save() == false)
        {
            throw new Exception('error_update_Stock',APP_ERROR);
        }
        return true;
    }



    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }


}
