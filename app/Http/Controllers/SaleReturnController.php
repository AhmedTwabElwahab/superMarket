<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleReturnRequest;
use App\Models\Client;
use App\Models\Journal;
use App\Models\PaymentType;
use App\Models\SaleReturn;
use App\Models\Stock;
use App\Models\Warehouse;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleReturnController extends Controller
{

    public function index(): View
    {
        $invoices = SaleReturn::with(['client','user'])->paginate(APP_PAGINATE);
        return $this->view(compact('invoices'));
    }


    public function create()
    {
        $Clients     = Client::all();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        return $this->view(compact('stocks','payments','Clients','warehouses'));
    }


    public function store(SaleReturnRequest $request)
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $invoice = SaleReturn::handelCreateInvoice($request);

            $invoice->handelCreateDetail($request);

            $journal = Journal::createJournalEntry($invoice->id,$invoice->doctype(),$invoice->description());

            $journal->handelSaleReturn($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('saleReturn.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }


    public function show(SaleReturn $saleReturn):View
    {
        return $this->view(compact('saleReturn'));
    }


    public function edit(SaleReturn $saleReturn):View
    {
        $Clients     = Client::all();
        $payments    = PaymentType::all();
        $stocks      = Stock::all();
        $warehouses  = Warehouse::all();
        return $this->view(compact('stocks','payments','Clients','warehouses','saleReturn'));
    }


    public function update(SaleReturnRequest $request, SaleReturn $saleReturn): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $saleReturn->handelUpdateSaleReturnInvoice($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('saleReturn.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            dd($e->getMessage());
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }


    public function destroy(SaleReturn $saleReturn): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $saleReturn->handelDeleteInvoice();

            DB::commit();
            $this->success('success_add');
            return redirect()->route('saleReturn.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }
}
