<?php

namespace App\Models;

use App\Http\Traits\Details;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SaleInvoiceDetail
 * @package App\Models
 *
 * @property integer $id
 * @property integer $barcode
 * @property integer $product_id
 * @property integer $quantity
 * @property integer $price
 * @property integer $profit
 * @property integer $invoice_id
 * @property integer $total_row
 *
 * RELATIONS PROPERTIES
 *
 * @property Product     $product
 * @property SaleInvoice $invoice
 *
 * @method static SaleInvoiceDetail find(int $int)
 * @method static SaleInvoiceDetail get()
 */
class SaleInvoiceDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
    public function invoice(): HasOne
    {
        return $this->hasOne(SaleInvoice::class,'id','invoice_id');
    }
}
