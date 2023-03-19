<?php

namespace App\Models;

use App\Http\Requests\PurchaseInvoiceRequest;
use App\Http\Requests\PurchaseReturnRequest;
use App\Http\Requests\SaleInvoiceRequest;
use App\Http\Requests\SaleReturnRequest;
use App\Http\Requests\ReceiptRequest;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Journal
 * @package App\Models
 *
 * @property integer $id
 * @property string $dec
 * @property string $date
 * @property integer $doc_id
 * @property integer $doc_type_id
 * @property integer $created_by
 *
 * RELATIONS PROPERTIES
 *
 * @property JournalEntryDebit $debitEntries
 * @property JournalEntryCredit $creditEntries
 *
 * @method static Journal find(int $int)
 * @method static Journal get()
 */
class Journal extends Model
{
    use HasFactory;

    /**
     * @param int $DocID
     * @param int $DocTypeID
     * @param string $dec
     * @return Journal
     * @throws Exception
     */
    public static function createJournalEntry(int $DocID, int $DocTypeID,string $dec): Journal
    {
        $Journal = new Journal();
        $Journal->doc_id            = $DocID;
        $Journal->doc_type_id       = $DocTypeID;
        $Journal->dec               = $dec;
        $Journal->date              = now();
        $Journal->created_by        = User::activeUser()->id;

        if ($Journal->save() == false)
        {
            throw new Exception('error',APP_ERROR);
        }
        return $Journal;
    }

    /**
     * @param int   $account
     * @param float $balance
     * @return bool
     * @throws Exception
     */
    public function createDebitEntry(int $account, float $balance): bool
    {
        $journal = new JournalEntryDebit();
        $journal->balance    = $balance;
        $journal->account_id = $account;
        $journal->journal_id = $this->id;

        if ($journal->save() == false)
        {
            throw new Exception('error',APP_ERROR);
        }

        $journal->account->updateAccount($balance,TRAN_DEBIT);

        return true;
    }

    /**
     * @param int   $account
     * @param float $balance
     * @return bool
     * @throws Exception
     */
    public function createCreditEntry(int $account,float $balance): bool
    {
        $Journal = new JournalEntryCredit();
        $Journal->balance    = $balance;
        $Journal->account_id = $account;
        $Journal->journal_id = $this->id;

        if ($Journal->save() == false)
        {
            throw new Exception('error',APP_ERROR);
        }

        $Journal->account->updateAccount($balance,TRAN_CREDIT);

        return true;
    }

    /**
     * @param int $account
     * @param float $balance
     * @param Account|null $newAccount
     * @return bool
     * @throws Exception
     */
    protected function updateDebitEntry(int $account, float $balance,Account $newAccount = null): bool
    {

        foreach ($this->debitEntries as $entry)
        {
            ///////////////////errrrrror  test invoice
            if ($entry->account_id == $account)
            {
                $entry->account->updateAccount($entry->balance, TRAN_DEBIT_);

                if ($newAccount != null && $account != $newAccount->id)
                {
                    $result = $entry->update(['account_id' => $newAccount->id, 'balance' => $balance]);
                } else
                {
                    $result = $entry->update(['balance' => $balance]);
                }
                if ($result == false)
                {
                    throw new Exception('error_update', APP_ERROR);
                }
                if ($newAccount != null && $newAccount->id != $account)
                {
                    return $newAccount->updateAccount($balance,TRAN_DEBIT);
                }
                return $entry->account->updateAccount($balance,TRAN_DEBIT);
            }
        }
        return false;
    }

    /**
     * @param int $account
     * @param int $balance
     * @param Account|null $newAccount
     * @return bool
     * @throws Exception
     */
    protected function updateCreditEntry(int $account, int $balance,Account $newAccount = null): bool
    {
        foreach ($this->creditEntries as $entry)
        {
            if ($entry->account_id == $account)
            {
                $entry->account->updateAccount($entry->balance,TRAN_CREDIT_);

                if ($newAccount != null && $account != $newAccount->id)
                {
                    $result = $entry->update(['account_id' => $newAccount->id,'balance' => $balance]);
                }
                else
                {
                    $result = $entry->update(['balance' => $balance]);
                }
                if ($result == false)
                {
                    throw new Exception('error_update',APP_ERROR);
                }

                if ($newAccount != null && $newAccount->id != $account)
                {
                    return $newAccount->updateAccount($balance,TRAN_CREDIT);

                }
                return $entry->account->updateAccount($balance,TRAN_CREDIT);
            }
        }
        return false;
    }

    /**
     * @param SaleInvoiceRequest $request
     * @return bool|null
     * @throws Exception
     */
    public function handelSaleInvoice(SaleInvoiceRequest $request): ?bool
    {
        $account_client   = (new Client)->find($request->input('client_id'))->account;
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $discount         = $request->input('discount') != null ?  $request->input('discount') : 0;
        $amount_paid      = $request->input('amount_paid') != null ?  $request->input('amount_paid') : 0;
        $final            = $totalBill - $discount;

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->createDebitEntry(User::activeUser()->cashBox(),$final);
                    $this->createDebitEntry($account_client->id,0);
                    $this->createDebitEntry(VISA_ACCOUNT,0);
                    $this->createDebitEntry(DISCOUNT_ALLOWED_ACCOUNT,$discount);
                //TO
                    $this->createCreditEntry(SALES_ACCOUNT,$totalBill);
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->createDebitEntry(User::activeUser()->cashBox(), $amount_paid);
                    $this->createDebitEntry($account_client->id,$final - $amount_paid);
                    $this->createDebitEntry(VISA_ACCOUNT,0);
                    $this->createDebitEntry(DISCOUNT_ALLOWED_ACCOUNT,$discount);
                //TO
                    $this->createCreditEntry(SALES_ACCOUNT,$totalBill);
                break;
            case PAYMENT_VISA:
                //FROM
                    $this->createDebitEntry(User::activeUser()->cashBox(),$amount_paid);
                    $this->createDebitEntry(VISA_ACCOUNT,$final - $amount_paid);
                    $this->createDebitEntry($account_client->id,0);
                    $this->createDebitEntry(DISCOUNT_ALLOWED_ACCOUNT,$discount);
                //TO
                    $this->createCreditEntry(SALES_ACCOUNT,$totalBill);
                break;
            default:
                return null;
        }
        return true;
    }

    /**
     * @param SaleInvoice $invoice
     * @param SaleInvoiceRequest $request
     * @return bool|null
     * @throws Exception
     */
    public function handelUpdateSaleInvoice(SaleInvoice $invoice, SaleInvoiceRequest $request): ?bool
    {
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $account_client   = (new Client)->find($request->input('client_id'))->account;
        $cash_box         = Account::find(User::activeUser()->cashBox());
        $discount         = $request->input('discount') != null ?  $request->input('discount') : 0;
        $amount_paid      = $request->input('amount_paid') != null ?  $request->input('amount_paid') : 0;
        $final            = $totalBill - $discount;

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->updateDebitEntry($invoice->cash_box_id,$final,$cash_box);//20
                    $this->updateDebitEntry($invoice->client->account_id,0,$account_client);//15
                    $this->updateDebitEntry(VISA_ACCOUNT,0);//0
                    $this->updateDebitEntry(DISCOUNT_ALLOWED_ACCOUNT,$discount);//5
                //TO
                    $this->updateCreditEntry(SALES_ACCOUNT,$totalBill);//40
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->updateDebitEntry($invoice->cash_box_id,$amount_paid,$cash_box);
                    $this->updateDebitEntry($invoice->client->account_id,$final - $amount_paid,$account_client);
                    $this->updateDebitEntry(VISA_ACCOUNT,0);
                    $this->updateDebitEntry(DISCOUNT_ALLOWED_ACCOUNT,$discount);
                //TO
                    $this->updateCreditEntry(SALES_ACCOUNT,$totalBill);
                break;
            case PAYMENT_VISA:
                //FROM
                    $this->updateDebitEntry($invoice->cash_box_id,$amount_paid,$cash_box);
                    $this->updateDebitEntry($invoice->client->account_id,0,$account_client);
                    $this->updateDebitEntry(VISA_ACCOUNT,$final - $amount_paid);
                    $this->updateDebitEntry(DISCOUNT_ALLOWED_ACCOUNT,$discount);
                //TO
                    $this->updateCreditEntry(SALES_ACCOUNT,$totalBill);
                break;
            default:
                return null;
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function handelDeleteInvoice(): bool
    {
        foreach ($this->creditEntries as $entry)
        {
            $entry->account->updateAccount($entry->balance,TRAN_CREDIT_);
            if ($entry->delete() == false)
            {
                throw new Exception('error_delete_invoice',APP_ERROR);
            }
        }
        foreach ($this->debitEntries as $entry)
        {
            $entry->account->updateAccount($entry->balance,TRAN_DEBIT_);
            if ($entry->delete() == false)
            {
                throw new Exception('error_delete_invoice',APP_ERROR);
            }
        }
        if ($this->delete() == false)
        {
            throw new Exception('error_delete_invoice',APP_ERROR);
        }
        return true;
    }


    /**
     * @param PurchaseInvoiceRequest $request
     * @return bool|null
     * @throws Exception
     */
    public function handelPurchaseInvoice(PurchaseInvoiceRequest $request): ?bool
    {
        $account_Supplier = (new Supplier)->find($request->input('supplier_id'))->account;
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $discount         = $request->input('discount') != null ?  $request->input('discount') : 0;
        $amount_paid      = $request->input('amount_paid') != null ?  $request->input('amount_paid') : 0;
        $final            = $totalBill - $discount;

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->createDebitEntry(PURCHASES_ACCOUNT,$totalBill);
                //TO
                    $this->createCreditEntry(User::activeUser()->cashBox(),$final);
                    $this->createCreditEntry($account_Supplier->id,0);
                    $this->createCreditEntry(VISA_ACCOUNT,0);
                    $this->createCreditEntry(DISCOUNT_RECEIVED_ACCOUNT,$discount);
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->createDebitEntry(PURCHASES_ACCOUNT,$totalBill);
                //TO
                    $this->createCreditEntry(User::activeUser()->cashBox(), $amount_paid);
                    $this->createCreditEntry($account_Supplier->id,$final - $amount_paid);
                    $this->createCreditEntry(VISA_ACCOUNT,0);
                    $this->createCreditEntry(DISCOUNT_RECEIVED_ACCOUNT,$discount);
                break;
            case PAYMENT_VISA:
                //FROM
                    $this->createDebitEntry(PURCHASES_ACCOUNT,$totalBill);
                //TO
                    $this->createCreditEntry(User::activeUser()->cashBox(),$amount_paid);
                    $this->createCreditEntry(VISA_ACCOUNT,$final - $amount_paid);
                    $this->createCreditEntry($account_Supplier->id,0);
                    $this->createCreditEntry(DISCOUNT_RECEIVED_ACCOUNT,$discount);
                break;
            default:
                return null;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function handelUpdatePurchaseInvoice(PurchaseInvoice $invoice, PurchaseInvoiceRequest $request): ?bool
    {
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $account_supplier = (new Supplier)->find($request->input('supplier_id'))->account;
        $cash_box         = Account::find(User::activeUser()->cashBox());
        $discount         = $request->input('discount') != null ?  $request->input('discount') : 0;
        $amount_paid      = $request->input('amount_paid') != null ?  $request->input('amount_paid') : 0;
        $final            = $totalBill - $discount;

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->updateDebitEntry(PURCHASES_ACCOUNT,$totalBill);//40
                //TO
                    $this->updateCreditEntry($invoice->cash_box_id,$final,$cash_box);//20
                    $this->updateCreditEntry($invoice->supplier->account_id,0,$account_supplier);//15
                    $this->updateCreditEntry(VISA_ACCOUNT,0);//0
                    $this->updateCreditEntry(DISCOUNT_RECEIVED_ACCOUNT,$discount);//5
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->updateDebitEntry(PURCHASES_ACCOUNT,$totalBill);
                //TO
                    $this->updateCreditEntry($invoice->cash_box_id,$amount_paid,$cash_box);
                    $this->updateCreditEntry($invoice->supplier->account_id,$final - $amount_paid,$account_supplier);
                    $this->updateCreditEntry(VISA_ACCOUNT,0);
                    $this->updateCreditEntry(DISCOUNT_RECEIVED_ACCOUNT,$discount);
                break;
            case PAYMENT_VISA:
                //FROM
                    $this->updateDebitEntry(PURCHASES_ACCOUNT,$totalBill);
                //TO
                    $this->updateCreditEntry($invoice->cash_box_id,$amount_paid,$cash_box);
                    $this->updateCreditEntry($invoice->supplier->account_id,0,$account_supplier);
                    $this->updateCreditEntry(VISA_ACCOUNT,$final - $amount_paid);
                    $this->updateCreditEntry(DISCOUNT_RECEIVED_ACCOUNT,$discount);
                break;
            default:
                return null;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function handelSaleReturn(SaleReturnRequest $request): ?bool
    {
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $account_client   = (new Client)->find($request->input('client_id'))->account;
        $cash_box         = Account::find(User::activeUser()->cashBox());

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->createDebitEntry(SALES_RETURNS_ACCOUNT ,$totalBill);
                //TO
                    $this->createCreditEntry($cash_box->id,$totalBill);
                    $this->createCreditEntry($account_client->id,0);
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->createDebitEntry(SALES_RETURNS_ACCOUNT ,$totalBill);
                //TO
                    $this->createCreditEntry($cash_box->id, 0);
                    $this->createCreditEntry($account_client->id,$totalBill);
                break;
            default:
                return null;
        }
        return true;
    }

    /**
     * @param SaleReturn $invoice
     * @param SaleReturnRequest $request
     * @return bool|null
     * @throws Exception
     */
    public function handelUpdateSaleReturnInvoice(SaleReturn $invoice, SaleReturnRequest $request): ?bool
    {
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $account_client   = (new Client)->find($request->input('client_id'))->account;
        $cash_box         = Account::find(User::activeUser()->cashBox());

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->updateDebitEntry(SALES_RETURNS_ACCOUNT ,$totalBill);
                //TO
                    $this->updateCreditEntry($invoice->cash_box_id,$totalBill,$cash_box);
                    $this->updateCreditEntry($invoice->client->account_id,0,$account_client);
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->updateDebitEntry(SALES_RETURNS_ACCOUNT ,$totalBill);
                //TO
                    $this->updateCreditEntry($invoice->cash_box_id,0,$cash_box);
                    $this->updateCreditEntry($account_client->id,$totalBill);
                break;
            default:
                return null;
        }
        return true;
    }

    /**
     * @param PurchaseReturnRequest $request
     * @return bool|null
     * @throws Exception
     */
    public function handelPurchaseReturn(PurchaseReturnRequest $request)
    {
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $account_supplier = (new Supplier)->find($request->input('supplier_id'))->account;
        $cash_box         = Account::find(User::activeUser()->cashBox());

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->createDebitEntry($cash_box->id,$totalBill);
                    $this->createDebitEntry($account_supplier->id,0);
                //TO
                    $this->createCreditEntry(PURCHASES_RETURNS_ACCOUNT ,$totalBill);
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->createDebitEntry($cash_box->id, 0);
                    $this->createDebitEntry($account_supplier->id,$totalBill);
                //TO
                    $this->createCreditEntry(PURCHASES_RETURNS_ACCOUNT ,$totalBill);
                break;
            default:
                return null;
        }
        return true;
    }

    /**
     * @param PurchaseReturn $invoice
     * @param PurchaseReturnRequest $request
     * @return bool|null
     * @throws Exception
     */
    public function handelUpdatePurchaseReturn(PurchaseReturn $invoice, PurchaseReturnRequest $request): ?bool
    {
        $paymentType      = $request->input('payment_type_id');
        $totalBill        = $request->input('total_bill');
        $account_supplier = (new Supplier)->find($request->input('supplier_id'))->account;
        $cash_box         = Account::find(User::activeUser()->cashBox());

        switch ($paymentType)
        {
            case PAYMENT_CASH:
                //FROM
                    $this->updateDebitEntry($invoice->cash_box_id,$totalBill,$cash_box);
                    $this->updateDebitEntry($invoice->supplier->account_id,0,$account_supplier);
                //TO
                    $this->updateCreditEntry(PURCHASES_RETURNS_ACCOUNT ,$totalBill);
                break;
            case PAYMENT_CREDIT:
                //FROM
                    $this->updateDebitEntry($invoice->cash_box_id, 0,$cash_box);
                    $this->updateDebitEntry($invoice->supplier->account_id,$totalBill,$account_supplier);
                //TO
                    $this->updateCreditEntry(PURCHASES_RETURNS_ACCOUNT ,$totalBill);
                break;
            default:
                return null;
        }
        return true;
    }
    /**
     * @param ReceiptRequest $request
     * @return bool
     * @throws Exception
     */
    public function handelCreateReceipt(ReceiptRequest $request): bool
    {
        $cash_box_id       = $request->input('cash_box_id');
        $account_id        = $request->input('account_id');
        $balance           = $request->input('balance');
        $type              = $request->input('type_id');

        if($type == RECEIPT_IN)
        {
            //FROM
                $this->createDebitEntry($cash_box_id ,$balance);
            //TO
                $this->createCreditEntry($account_id,$balance);
            return true;
        }
        if($type == RECEIPT_OUT)
        {
            //FROM
                $this->createDebitEntry($account_id ,$balance);
            //TO
                $this->createCreditEntry($cash_box_id,$balance);
            return true;
        }
        return false;
    }

    /**
     * @param Receipt $receipt
     * @param ReceiptRequest $request
     * @return bool
     * @throws Exception
     */
    public function handelUpdateReceipt(Receipt $receipt , ReceiptRequest $request): bool
    {
        $cash_box_id       = Account::find($request->input('cash_box_id'));
        $account           = Account::find($request->input('account_id'));
        $balance           = $request->input('balance');


        if($this->doc_type_id == RECEIPT_IN)
        {
            //FROM
                $this->updateDebitEntry($receipt->cash_box_id, $balance,$cash_box_id);
            //TO
                $this->updateCreditEntry($receipt->account_id,$balance,$account);
            return true;
        }
        if($this->doc_type_id == RECEIPT_OUT)
        {
            //FROM
                $this->updateDebitEntry($receipt->account_id,$balance,$account);
            //TO
                $this->updateCreditEntry($receipt->cash_box_id, $balance,$cash_box_id);
            return true;
        }
        return false;
    }


    public function debitEntries(): HasMany
    {
        return $this->hasMany(JournalEntryDebit::class,'journal_id','id');
    }

    public function creditEntries(): HasMany
    {
        return $this->hasMany(JournalEntryCredit::class,'journal_id','id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','created_by');
    }



}
