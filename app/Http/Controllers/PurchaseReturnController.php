<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseReturnRequest;
use App\Models\Journal;
use App\Models\PaymentType;
use App\Models\PurchaseReturn;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{

    public function index():View
    {
        $invoices = PurchaseReturn::with(['supplier','user'])->paginate(APP_PAGINATE);
        return $this->view(compact('invoices'));
    }


    public function create():View
    {
        $suppliers   = Supplier::all();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        return $this->view(compact('stocks','payments','suppliers','warehouses'));
    }


    public function store(PurchaseReturnRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            //dd($request->all());
            $invoice = PurchaseReturn::handelCreateInvoice($request);

            $invoice->handelCreateDetail($request);

            $journal = Journal::createJournalEntry($invoice->id,$invoice->doctype(),$invoice->description());

            $journal->handelPurchaseReturn($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('purchaseReturn.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            dd($e->getMessage());
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }


    public function edit(PurchaseReturn $purchaseReturn)
    {
        $suppliers   = Supplier::all();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        return $this->view(compact('stocks','payments','suppliers','warehouses','purchaseReturn'));
    }


    public function update(PurchaseReturnRequest $request, PurchaseReturn $purchaseReturn): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $purchaseReturn->handelUpdateSaleReturnInvoice($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('purchaseReturn.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(PurchaseReturn $purchaseReturn): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $purchaseReturn->handelDeleteInvoice();

            DB::commit();
            $this->success('success_add');
            return redirect()->route('purchaseReturn.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }
}
