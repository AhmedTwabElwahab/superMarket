<?php

namespace App\Models;

use App\Http\Interfaces\InvoiceFunc;
use App\Http\Requests\PurchaseReturnRequest;
use App\Http\Traits\Invoice;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * Class PurchaseReturn
 * @package App\Models
 *
 * @property integer $id
 * @property integer $payment_type_id
 * @property integer $total_bill
 * @property integer $supplier_id
 * @property integer $warehouse_id
 * @property integer $cash_box_id
 * @property integer $created_by
 * @property string  $notes
 *
 * RELATIONS PROPERTIES
 *
 * @property Supplier                $supplier
 * @property PaymentType             $paymentType
 * @property PurchaseReturnDetail[]  $details
 *
 *
 * @method static PurchaseReturn    find(int $int)
 * @method static PurchaseReturn[]  get()
 * @method static PurchaseReturn    findOrFail(int $id)
 * @method static where(...$args)
 */
class PurchaseReturn extends Model implements InvoiceFunc
{
    use HasFactory,SoftDeletes,Invoice;

    protected $guarded =[];



    public function details(): HasMany
    {
        return $this->hasMany(PurchaseReturnDetail::class,'invoice_id','id');
    }
    public function doctype(): int
    {
        return PURCHASE_RETURN;
    }
    public function description(): string
    {
        return 'فاتورة مرتجع شراء رقم('.$this->id.')';
    }
    public function getDetailInstance():PurchaseReturnDetail
    {
        return new PurchaseReturnDetail();
    }


    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class,'id','supplier_id');
    }

    /**
     * @throws \Exception
     */
    public function handelUpdateSaleReturnInvoice(PurchaseReturnRequest $request)
    {
        if (
            $this->supplier_id      != $request->input('supplier_id') ||
            $this->payment_type_id  != $request->input('payment_type_id') ||
            $this->total_bill       != $request->input('total_bill'))
        {
            $Journal = $this->getJournalEntry();
            $Journal->handelUpdatePurchaseReturn($this, $request);
        }
        $this->supplier_id      = $request->input('supplier_id');
        $this->payment_type_id  = $request->input('payment_type_id');
        $this->notes            = $request->input('notes');
        $this->total_bill       = $request->input('total_bill');

        if ($this->update() == false)
        {
            throw new Exception('error_update', APP_ERROR);
        }

        if ($request->has('details_id') == false)
        {
            throw new Exception('error', APP_ERROR);
        }

        foreach ($this->details as $detail)
        {
            $key = array_search($detail->id, $request->input('details_id'));

            if ($key !== false)
            {
                $Detail   = PurchaseReturnDetail::find($detail->id);
                $quantity = $request->input('quantity')[$key] - $Detail->quantity;
                $type     = $quantity > 0 ? STOCK_OUT : STOCK_IN;

                if ($quantity != 0)
                {
                    $result = $Detail->update([
                        'quantity'      => $request->input('quantity')[$key],
                        'price'         => $request->input('purchase_price')[$key],
                        'total_row'     => $request->input('total_row')[$key],
                    ]);
                    if ($result == false)
                    {
                        throw new Exception('error_update',APP_ERROR);
                    }
                    $Detail->product->stockCustom($this->warehouse_id)->updateStock(abs($quantity),$this->doctype(),$type);
                }
            }
            else
            {
                if ($detail->delete() == false)
                {
                    throw new Exception('error_update_invoice',APP_ERROR);
                }
            }
        }
        return  $this->handelCreateDetail($request);
    }

}
