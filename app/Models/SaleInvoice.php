<?php

namespace App\Models;

use App\Http\Interfaces\InvoiceFunc;
use App\Http\Requests\SaleInvoiceRequest;
use App\Http\Traits\Invoice;
use App\interfaces\IDocument;
use App\traits\IsDocument;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SalesInvoices
 * @package App\Models
 *
 * @property integer $id
 * @property integer $payment_type_id
 * @property integer $total_bill
 * @property integer $discount
 * @property integer $client_id
 * @property integer $warehouse_id
 * @property integer $cash_box_id
 * @property integer $created_by
 * @property string  $amount_paid
 * @property string  $notes
 *
 * RELATIONS PROPERTIES
 *
 * @property Client              $client
 * @property PaymentType         $paymentType
 * @property SaleInvoiceDetail[] $details
 *
 *
 * @method static SaleInvoice find(int $int)
 * @method static SaleInvoice[] get()
 * @method static SaleInvoice findOrFail(int $id)
 * @method static where(...$args)
 */
class SaleInvoice extends Model implements InvoiceFunc
{
    use HasFactory,SoftDeletes,Invoice;

    protected $guarded = [];

    /**
     * @param SaleInvoiceRequest $request
     * @return bool
     * @throws Exception
     */
    public function handelUpdateSaleInvoice(SaleInvoiceRequest $request): bool
    {
        if (
            $this->client_id        != $request->input('client_id') ||
            $this->payment_type_id  != $request->input('payment_type_id') ||
            $this->discount         != $request->input('discount') ||
            $this->total_bill       != $request->input('total_bill'))
        {
            $Journal = $this->getJournalEntry();
            $Journal->handelUpdateSaleInvoice($this, $request);
        }

        $this->client_id        = $request->input('client_id');
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
                $Detail   = SaleInvoiceDetail::find($detail->id);
                $quantity = $request->input('quantity')[$key] - $Detail->quantity;
                $type     = $quantity > 0 ? STOCK_OUT : STOCK_IN;

                if ($quantity != 0)
                {
                    $result = $Detail->update([
                        'quantity'      => $request->input('quantity')[$key],
                        'price'         => $request->input('sale_price')[$key],
                        'total_row'     => $request->input('total_row')[$key],
                        'profit'        => $request->input('sale_price')[$key] - $Detail->product->purchase_price,
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


    public function client(): HasOne
    {
        return $this->hasOne(Client::class,'id','client_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(SaleInvoiceDetail::class,'invoice_id','id');
    }

    public function doctype(): int
    {
        return SALES_INVOICE;
    }
    public function description(): string
    {
        return 'فاتورة بيع رقم('.$this->id.')';
    }
    public function getDetailInstance():SaleInvoiceDetail
    {
        return new SaleInvoiceDetail();
    }
}
