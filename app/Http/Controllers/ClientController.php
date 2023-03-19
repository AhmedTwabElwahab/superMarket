<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Models\Account;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->init();
        $this->middlewareInit();
    }

    public function index(): View
    {
        $clients = Client::paginate(APP_PAGINATE);
        return $this->view(compact('clients'));
    }

    public function create(): View
    {
        return $this->view();
    }

    public function store(PersonRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try {
            $client = new Client($request->all());

            $Account = Account::CreateAccount($client->name ,$client->SubAccount());

            if ($Account == false)
            {
                throw new Exception('error',APP_ERROR);
            }

            $client->account_id = $Account->id;

            if ($client->save() == false)
            {
                throw new Exception('error',APP_ERROR);
            }

            DB::commit();
            $this->success('success_add');
            return redirect()->route('client.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }

    public function edit(Client $client): View
    {
        return $this->view(compact('client'));
    }

    public function update(PersonRequest $request, Client $client): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            if ($client->update($request->all()) == false)
            {
                throw new Exception('error',APP_ERROR);
            }
            DB::commit();
            $this->success('update_success');
            return redirect()->route('client.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try {
            //TODO::DELETE METHOD
//            if ($client->account->transactions->isNotEmpty())
//            {
//                throw new Exception('delete_error',APP_ERROR);
//            }
            if ($client->delete() == false)
            {
                throw new Exception('delete_error',APP_ERROR);
            }
            $client->account->delete();
            DB::commit();
            $this->success('success_delete');
            return redirect()->route('client.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back();
        }
    }
}
