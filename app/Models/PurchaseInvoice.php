<?php

namespace App\Models;

use App\Http\Interfaces\InvoiceFunc;
use App\Http\Requests\PurchaseInvoiceRequest;
use App\Http\Traits\Invoice;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PurchaseInvoice
 * @package App\Models
 *
 * @property integer $id
 * @property integer $payment_type_id
 * @property integer $total_bill
 * @property integer $discount
 * @property integer $supplier_id
 * @property integer $warehouse_id
 * @property integer $cash_box_id
 * @property integer $created_by
 * @property string  $amount_paid
 * @property string  $notes
 *
 * RELATIONS PROPERTIES
 *
 * @property Supplier                $supplier
 * @property PaymentType             $paymentType
 * @property PurchaseInvoiceDetail[] $details
 *
 *
 * @method static PurchaseInvoice find(int $int)
 * @method static PurchaseInvoice[] get()
 * @method static PurchaseInvoice findOrFail(int $id)
 * @method static where(...$args)
 */
class PurchaseInvoice extends Model implements InvoiceFunc
{
    use HasFactory,SoftDeletes,Invoice;

    protected $guarded = [];


    /**
     * @throws Exception
     */
    public function handelUpdatePurchaseInvoice(PurchaseInvoiceRequest $request): bool
    {
        if (
            $this->supplier_id      != $request->input('supplier_id') ||
            $this->payment_type_id  != $request->input('payment_type_id') ||
            $this->discount         != $request->input('discount') ||
            $this->total_bill       != $request->input('total_bill'))
        {
            $Journal = $this->getJournalEntry();
            $Journal->handelUpdatePurchaseInvoice($this, $request);
        }

        $this->supplier_id      = $request->input('supplier_id');
        $this->payment_type_id  = $request->input('payment_type_id');
        $this->discount         = $request->input('discount');
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
                $Detail   = PurchaseInvoiceDetail::find($detail->id);
                $quantity = $request->input('quantity')[$key] - $Detail->quantity;
                $type     = $quantity > 0 ? STOCK_IN : STOCK_OUT ;
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


    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class,'id','supplier_id');
    }

    public function warehouse(): HasOne
    {
        return $this->hasOne(Warehouse::class,'id','warehouse_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','created_by');
    }

    public function paymentType(): HasOne
    {
        return $this->hasOne(PaymentType::class,'id','payment_type_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseInvoiceDetail::class,'invoice_id','id');
    }

    public function doctype(): int
    {
        return PURCHASE_INVOICE;
    }

    public function description(): string
    {
        return 'فاتورة شراء رقم('.$this->id.')';
    }

    public function getDetailInstance():PurchaseInvoiceDetail
    {
        return new PurchaseInvoiceDetail();
    }
}
