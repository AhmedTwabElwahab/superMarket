<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\AccountType;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class AccountController extends Controller
{

    public function index():View
    {
        $accounts = Account::paginate(APP_PAGINATE);
        return $this->view(compact('accounts'));
    }

    public function create():View
    {
        $accountType = AccountType::all();
        return $this->view(compact('accountType'));
    }

    /**
     * @param AccountRequest $request
     * @return RedirectResponse
     */
    public function store(AccountRequest $request): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $account = Account::createAccount(
                $request->input('account_name'),
                $request->input('sub_account_id')
            );

            if ($account == null)
            {
                throw new Exception('error_creat_account',APP_ERROR);
            }

            DB::commit();
            $this->success('success_add');
            return redirect()->route('account.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }

    public function edit(Account $account):View
    {
        return $this->view(compact('account'));
    }

    public function show(Account $account):View
    {
        $trans = $account->transactionDebit->merge($account->transactionCredit)->sortBy('created_at');
        return $this->view(compact('account','trans'));
    }

    public function update(AccountRequest $request, Account $account): RedirectResponse
    {
        $this->init();
        DB::beginTransaction();
        try
        {
            $result = $account->update([
                'name'              => $request->input('account_name'),
                'sub_account_id'    => $request->input('sub_account_id'),
            ]);

            if ($result == null)
            {
                throw new Exception('error_update_account',APP_ERROR);
            }

            DB::commit();
            $this->success('success_add');
            return redirect()->route('account.index');
        } catch (Exception $e)
        {
            DB::rollBack();
            $message = $this->handleException($e);
            $this->setSystemMessage($message);
            return redirect()->back()->withInput();
        }
    }

    public function getAccount(Request $request)
    {
        return Account::getAccount($request);
    }

    public function getMainAccount(Request $request)
    {
        return Account::getMainAccount($request);
    }

    public function getSubAccount(Request $request)
    {
        return Account::getSubAccount($request);
    }

}
