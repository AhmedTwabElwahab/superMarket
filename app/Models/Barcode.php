<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Barcode
 * @package App\Models
 *
 * @property integer  $id
 * @property integer  $product_id
 * @property string   $barcode
 *
 **/

class Barcode extends Model
{
    use HasFactory;

    protected $guarded =[];

    /**
     * @param int $product_id
     * @param array $barcode_array
     * @throws Exception
     */
    public static function createBarcode(int $product_id, array $barcode_array)
    {
       foreach ($barcode_array as $code)
       {
           $barcode = new self();

           $barcode->barcode    = $code;
           $barcode->product_id = $product_id;

           if ($barcode->save() == false)
           {
               throw new Exception('error_create_barcode',APP_ERROR);
           }
       }
    }

    /**
     * @param Product $product
     * @param array $barcodes
     * @throws Exception
     */
    public static function updateBarcode(Product $product, array $barcodes)
    {
        foreach ($barcodes as $code)
        {
            if (!in_array($code, (array)$product->barcode))
            {
                $barcode = new self();

                $barcode->barcode    = $code;
                $barcode->product_id = $product->id;

                if ($barcode->save() == false)
                {
                    throw new Exception('error_create_barcode',APP_ERROR);
                }
            }
        }
    }
}

