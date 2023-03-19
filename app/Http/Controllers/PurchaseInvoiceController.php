<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseInvoiceRequest;
use App\Models\Journal;
use App\Models\PaymentType;
use App\Models\PurchaseInvoice;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Warehouse;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceController extends Controller
{
    public function index():View
    {
        $invoices = PurchaseInvoice::with(['supplier','user'])->paginate(APP_PAGINATE);
        return $this->view(compact('invoices'));
    }

    public function create():View
    {
        $suppliers   = Supplier::with(['account'])->get();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        return $this->view(compact('stocks','payments','suppliers','warehouses'));
    }

    /**
     * @param PurchaseInvoiceRequest $request
     * @return RedirectResponse
     */
    public function store(PurchaseInvoiceRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $invoice = PurchaseInvoice::handelCreateInvoice($request);

            $invoice->handelCreateDetail($request);

            $journal = Journal::createJournalEntry($invoice->id,$invoice->doctype(),$invoice->description());

            $journal->handelPurchaseInvoice($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('purchaseInvoice.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }

    public function show(PurchaseInvoice $purchaseInvoice): View
    {
        return $this->view(compact('purchaseInvoice'));
    }

    public function edit(PurchaseInvoice $purchaseInvoice):View
    {
        $suppliers   = Supplier::all();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        return $this->view(compact('stocks','payments','suppliers','warehouses','purchaseInvoice'));
    }

    public function update(PurchaseInvoiceRequest $request, PurchaseInvoice $purchaseInvoice): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $purchaseInvoice->handelUpdatePurchaseInvoice($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('purchaseInvoice.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(PurchaseInvoice $purchaseInvoice): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $purchaseInvoice->handelDeleteInvoice();

            DB::commit();
            $this->success('success_destroy');
            return redirect()->route('saleInvoice.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            dd($e->getMessage());
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }
}
