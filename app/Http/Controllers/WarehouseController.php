<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
     public function __construct()
     {
         $this->init();
         $this->middlewareInit();
     }

    public function index()
    {
        $warehouse = Warehouse::paginate(APP_PAGINATE);
        return $this->view(compact('warehouse'));
    }


    public function create():View
    {
        return $this->view();
    }


    public function store(Request $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $warehouse = new Warehouse($request->all());

            if ($warehouse->save() == false)
            {
                throw new Exception('error',APP_ERROR);
            }

            DB::commit();
            $this->success('success_add');
            return redirect()->route('warehouse.index');

        }catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->route('warehouse.index');
        }
    }

    public function edit(Warehouse $warehouse)
    {
        return $this->view(compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $warehouse->update($request->all());

            if ($warehouse->save() == false)
            {
                throw new Exception('error',APP_ERROR);
            }

            DB::commit();
            $this->success('success_update');
            return redirect()->route('warehouse.index');
        }catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }


    public function destroy(Warehouse $warehouse)
    {
        //TODO:destroy method
    }
}
