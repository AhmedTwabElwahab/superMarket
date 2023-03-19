<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Models\Account;
use App\Models\Supplier;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    public function __construct()
    {
        $this->init();
        $this->middlewareInit();
    }

    public function index():View
    {
        $suppliers = Supplier::paginate(APP_PAGINATE);
        return $this->view(compact('suppliers'));
    }

    public function create():View
    {
        return $this->view();
    }

    public function store(PersonRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();

        try {
            $supplier = new Supplier($request->all());

            $account = Account::createAccount($supplier->name ,$supplier->subAccount());

            if ($account == null)
            {
                throw new Exception('error_create_account' ,APP_ERROR);
            }

            $supplier->account_id = $account->id;

            if ($supplier->save() == false)
            {
                throw new Exception('error' ,APP_ERROR);
            }

            DB::commit();
            $this->success('success');
            return redirect()->route('supplier.index');
        } catch (Exception $e)
        {
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('supplier.index');
        }
    }


    public function edit(Supplier $supplier):View
    {
        return $this->view(compact('supplier'));
    }

    public function update(PersonRequest $request, Supplier $supplier): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try {
            if ($supplier->update($request->all()) == false)
            {
                throw new Exception('error',APP_ERROR);
            }

            DB::commit();
            $this->success('update_success');
            return redirect()->route('supplier.index');
        } catch (Exception $e)
        {
            DB::rollback();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('supplier.index');
        }
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try {
            //TODO:supplier delete method
//            if ($supplier->account->transactions->isNotEmpty())
//            {
//                throw new Exception('delete_error',APP_ERROR);
//            }
            if ($supplier->delete() == false)
            {
                throw new Exception('delete_error',APP_ERROR);
            }
           // $supplier->account->delete();

            DB::commit();
            $this->success('delete_success');
            return redirect()->route('suppliers.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('suppliers.index');
        }
    }
}
