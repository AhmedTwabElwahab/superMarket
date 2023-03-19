<?php

namespace App\Http\Traits;

use App\Models\Journal;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

trait Invoice
{

    /**
     * @throws Exception
     */
    public static function handelCreateInvoice(Request $request)
    {
        $invoice = new self();

        if ($invoice->doctype() == SALES_INVOICE)
        {
            $invoice->client_id         = $request->input('client_id');
            $invoice->discount          = $request->input('discount');
            $invoice->amount_paid       = $request->input('amount_paid') == null ? 0 : $request->input('amount_paid');
        }
        if ($invoice->doctype() == PURCHASE_INVOICE)
        {
            $invoice->supplier_id       = $request->input('supplier_id');
            $invoice->discount          = $request->input('discount');
            $invoice->amount_paid       = $request->input('amount_paid') == null ? 0 : $request->input('amount_paid');
        }
        if ($invoice->doctype() == SALES_RETURN)
        {
            $invoice->client_id         = $request->input('client_id');
        }
        if ($invoice->doctype() == PURCHASE_RETURN)
        {
            $invoice->supplier_id       = $request->input('supplier_id');
        }
        $invoice->warehouse_id          = $request->input('warehouse');
        $invoice->cash_box_id           = User::activeUser()->cashBox();
        $invoice->payment_type_id       = $request->input('payment_type_id');
        $invoice->notes                 = $request->input('notes');
        $invoice->total_bill            = $request->input('total_bill');
        $invoice->created_by            = User::activeUser()->id;

        if ($invoice->save() == false)
        {
            throw new Exception('error_create_invoice',APP_ERROR);
        }
        return $invoice;
    }


    /**
     * @throws Exception
     */
    public function handelCreateDetail(Request $request): bool
    {
        if (!$request->has('product_id_new_') || empty($request->input('product_id_new_')))
        {
            return false;
        }
        foreach ($request->input('product_id_new_') as $index => $id)
        {
            $Detail = $this->getDetailInstance();

            $Detail->invoice_id         = $this->id;
            $Detail->barcode            = $request->input('barcode_new_')[$index];
            $Detail->product_id         = $id;
            $Detail->quantity           = $request->input('quantity_new_')[$index];

            if ($this->doctype() == SALES_INVOICE || $this->doctype() == SALES_RETURN)
            {
                $Detail->price          = $request->input('sale_price_new_')[$index];
            }
            else
            {
                $Detail->price          = $request->input('purchase_price_new_')[$index];
            }

            $Detail->total_row          = $request->input('total_row_new')[$index];
            if ($this->doctype() == SALES_INVOICE)
            {
                $product = Product::find($id);
                $Detail->profit   = floatval($request->input('sale_price_new_')[$index] - $product->purchase_price);
            }


            if ($Detail->save() == false)
            {
                throw new Exception('SaleInvoiceDetail_FAILL',APP_ERROR);
            }

            if ($this->warehouse_id == null)
            {
                throw new Exception('SaleInvoiceDetail_FAILL',APP_ERROR);
            }
            //update stock value
            if ($this->doctype() == SALES_INVOICE || $this->doctype() == PURCHASE_RETURN)
            {
                $Detail->product->stockCustom($this->warehouse_id)->updateStock($Detail->quantity,$this->doctype(),STOCK_OUT);
            }
            else
            {
                $Detail->product->stockCustom($this->warehouse_id)->updateStock($Detail->quantity,$this->doctype(),STOCK_IN);
            }
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function handelDeleteInvoice(): bool
    {
        $type = STOCK_OUT;
        $this->getJournalEntry()->handelDeleteInvoice();

        if ($this->doctype() == SALES_INVOICE || $this->doctype() == PURCHASE_RETURN)
        {
            $type = STOCK_IN;
        }

        foreach ($this->details as $detail)
        {
            $detail->product->stockCustom($this->warehouse_id)
                ->updateStock($detail->quantity,$this->doctype(),$type);
            if ($detail->delete() == false)
            {
                throw new Exception('error_delete_invoice',APP_ERROR);
            }
        }

        if ($this->delete() == false)
        {
            throw new Exception('error_delete_invoice',APP_ERROR);
        }
        return true;
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

    /**
     * @return Journal
     * return Invoice entry
     */
    public function getJournalEntry():Journal
    {
        return Journal::where('doc_id',$this->id)->where('doc_type_id',$this->doctype())->first();
    }
}
