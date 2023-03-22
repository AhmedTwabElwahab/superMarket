<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleInvoiceRequest;
use App\Models\Client;
use App\Models\Journal;
use App\Models\PaymentType;
use App\Models\SaleInvoice;
use App\Models\Stock;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class SaleInvoiceController extends Controller
{
    public function __construct()
    {
        $this->init();
        $this->middlewareInit();
    }

    public function index():View
    {
        $invoices = SaleInvoice::with(['client','user'])->paginate(APP_PAGINATE);
        return $this->view(compact('invoices'));
    }

    public function create():View
    {
        $Clients     = Client::all();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        return $this->view(compact('stocks','payments','Clients','warehouses'));
    }

    public function store(SaleInvoiceRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $invoice = SaleInvoice::handelCreateInvoice($request);

            $invoice->handelCreateDetail($request);

            $journal = Journal::createJournalEntry($invoice->id,$invoice->doctype(),$invoice->description());

            $journal->handelSaleInvoice($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('saleInvoice.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }

    public function show(SaleInvoice $saleInvoice):View
    {
        return $this->view(compact('saleInvoice'));
    }

    public function edit(SaleInvoice $saleInvoice):View
    {
        $Clients     = Client::all();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        $Invoice     = $saleInvoice;
        return $this->view(compact('stocks','payments','Clients','Invoice','warehouses'));
    }

    public function update(SaleInvoiceRequest $request, SaleInvoice $saleInvoice): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $saleInvoice->handelUpdateSaleInvoice($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('saleInvoice.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }

    public function destroy(SaleInvoice $saleInvoice): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $saleInvoice->handelDeleteInvoice();

            DB::commit();
            $this->success('success_add');
            return redirect()->route('saleInvoice.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }
}
