<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Account;
use App\Models\Client;
use App\Models\Supplier;
use App\Models\Journal;
use Illuminate\Contracts\View\View;
use App\Http\Requests\ReceiptRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ReceiptController extends Controller
{
    // public function __construct()
    // {
    //     $this->init();
    //     $this->middlewareInit();
    // }

    public function index(): View
    {
        $receipts = Receipt::paginate(APP_PAGINATE);
        return $this->view(compact('receipts'));
    }

    
    public function create(Request $request): View
    {
        $type     = RECEIPT_IN;
        $cash_box = Account::where('sub_account_id',CASH_BOX)->get();
        if($request->has('rec'))
        {
           $type = $request->input('rec');
        }

        return $this->view(compact('type','cash_box'));
    }

    
    public function store(ReceiptRequest $request)
    {
        $this->init();
        DB::beginTransaction();
        try {
            
            $receipt = Receipt::createReceipt($request);
            $type    = $request->input('type_id');
            $journal = Journal::createJournalEntry($receipt->id,$type,$receipt->description());

            if($journal->handelCreateReceipt($request) == false)
            {
                throw new Exception('error_create_receipt',APP_ERROR);
            }

            DB::commit();
            $this->success('success_add');
            return redirect()->route('receipt.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }

    
    public function show(Receipt $receipt)
    {
        //
    }

    
    public function edit(Receipt $receipt)
    {
        $cash_box = Account::where('sub_account_id',CASH_BOX)->get();
        return $this->view(compact('receipt','cash_box'));
    }

    
    public function update(ReceiptRequest $request, Receipt $receipt)
    {
        $this->init();
        DB::beginTransaction();
        try {

            $receipt->updateReceipt($request);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('receipt.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            dd($e);
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }

    
    public function destroy(Receipt $receipt)
    {
        $this->init();
        DB::beginTransaction();
        try {

            $receipt->handelDeleteReceipt($receipt);

            DB::commit();
            $this->success('success_add');
            return redirect()->route('receipt.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            dd($e);
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
        //
    }
}
