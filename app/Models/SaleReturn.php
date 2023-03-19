<?php

namespace App\Models;

use App\Http\Interfaces\InvoiceFunc;
use App\Http\Requests\SaleReturnRequest;
use App\Http\Traits\Invoice;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SaleReturn
 * @package App\Models
 *
 * @property integer $id
 * @property integer $payment_type_id
 * @property integer $total_bill
 * @property integer $client_id
 * @property integer $warehouse_id
 * @property integer $cash_box_id
 * @property integer $created_by
 * @property string  $notes
 *
 * RELATIONS PROPERTIES
 *
 * @property Client              $client
 * @property PaymentType         $paymentType
 * @property SaleReturnDetail[]  $details
 *
 *
 * @method static SaleReturn find(int $int)
 * @method static SaleReturn[] get()
 * @method static SaleReturn findOrFail(int $id)
 * @method static where(...$args)
 */
class SaleReturn extends Model implements InvoiceFunc
{
    use HasFactory,SoftDeletes,Invoice;

    protected $guarded =[];


    public function client(): HasOne
    {
        return $this->hasOne(Client::class,'id','client_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(SaleReturnDetail::class,'invoice_id','id');
    }
    public function doctype(): int
    {
        return SALES_RETURN;
    }
    public function description(): string
    {
        return 'فاتورة مرتجع بيع رقم('.$this->id.')';
    }
    public function getDetailInstance():SaleReturnDetail
    {
        return new SaleReturnDetail();
    }

    /**
     * @param SaleReturnRequest $request
     * @return bool
     * @throws Exception
     */
    public function handelUpdateSaleReturnInvoice(SaleReturnRequest $request): bool
    {
        if (
            $this->client_id        != $request->input('client_id') ||
            $this->payment_type_id  != $request->input('payment_type_id') ||
            $this->total_bill       != $request->input('total_bill'))
        {
            $Journal = $this->getJournalEntry();
            $Journal->handelUpdateSaleReturnInvoice($this, $request);
        }
        $this->client_id        = $request->input('client_id');
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
                $Detail   = SaleReturnDetail::find($detail->id);
                $quantity = $request->input('quantity')[$key] - $Detail->quantity;
                $type     = $quantity > 0 ? STOCK_IN : STOCK_OUT;

                if ($quantity != 0)
                {
                    $result = $Detail->update([
                        'quantity'      => $request->input('quantity')[$key],
                        'price'         => $request->input('sale_price')[$key],
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
