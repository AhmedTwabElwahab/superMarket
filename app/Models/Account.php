<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
/**
 * Class Account
 * @package App\Models
 *
 * @property integer $id
 * @property string  $name
 * @property integer $total_Debit_balance
 * @property integer $total_credit_balance
 * @property integer $debit_balance
 * @property integer $credit_balance
 * @property integer $sub_account_id
 *
 * RELATIONS PROPERTIES
 * @property JournalEntryCredit[] $transactionCredit
 * @property JournalEntryDebit[] $transactionDebit
 *
 * @method static find(int|null $newAccountID)
 * @method static paginate(int $APP_PAGINATE)
 */
class Account extends Model
{
    use HasFactory;

    public static function createAccount(string $name,int $SubAccount): ?Account
    {

        if($SubAccount == SUPPLIERS_ACCOUNT)
        {
            $name = 'حساب مورد:'.$name;
        }
        if($SubAccount == CLIENTS_ACCOUNT)
        {
            $name = 'حساب عميل:'.$name;
        }
        $account = new Account();
        $account->name                             = $name ;
        $account->sub_account_id                   = $SubAccount ;

        if ($account->save())
        {
            return $account;
        }
        return null;
    }

    /**
     * @param float $balance
     * @param int $TranType
     * @return bool
     * @throws Exception
     */
    public function updateAccount(float $balance, int $TranType): bool
    {
        if ($TranType == TRAN_DEBIT_)
        {
            $this->total_Debit_balance -= $balance;
        }
        if ($TranType == TRAN_CREDIT_)
        {
            $this->total_credit_balance -= $balance;
        }
        if ($TranType == TRAN_DEBIT)
        {
            $this->total_Debit_balance += $balance;
        }
        if ($TranType == TRAN_CREDIT)
        {
            $this->total_credit_balance += $balance;
        }
        if ($this->total_Debit_balance >  $this->total_credit_balance)
        {
            $this->debit_balance  = $this->total_Debit_balance - $this->total_credit_balance;
            $this->credit_balance = 0;
        }
        else
        {
            $this->credit_balance = $this->total_credit_balance - $this->total_Debit_balance;
            $this->debit_balance  = 0;
        }
        if ($this->save() == false)
        {
            throw new Exception('error',APP_ERROR);
        }
        return true;
    }

    public static function getAccount(Request $request)
    {
        if ($request->has('type'))
        {
            if($request->input('type') == ALL_ACCOUNT)
            {
                return  Account::all();
            }
            return  Account::where('sub_account_id',$request->input('type'))->get();
        }
        return false;
    }

    public static function getMainAccount(Request $request)
    {
        if ($request->has('type'))
        {
            return  MainAccount::where('type_id',$request->input('type'))->get();
        }
        return false;
    }

    public static function getSubAccount(Request $request)
    {
        if ($request->has('main_account_id'))
        {
            return  SubAccount::where('main_account_id',$request->input('main_account_id'))->get();
        }
        return false;
    }

    public function subAccount():HasOne
    {
        return $this->hasOne(SubAccount::class,'id','sub_account_id');
    }

    public function transactionCredit(): HasMany
    {
        return $this->hasMany(JournalEntryCredit::class,'account_id','id');
    }

    public function transactionDebit(): HasMany
    {
        return $this->hasMany(JournalEntryDebit::class,'account_id','id');
    }
}
