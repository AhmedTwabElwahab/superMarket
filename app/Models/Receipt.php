<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Http\Requests\ReceiptRequest;

/**
 * Class Receipt
 * @package App\Models
 *
 * @property integer $id
 * @property integer $cash_box_id
 * @property integer $account_id
 * @property integer $type_id
 * @property integer $balance
 * @property string  $notes
 * @property integer $created_by
 *
 * RELATIONS PROPERTIES
 *
 */
class Receipt extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $dateFormat = 'Y:m:d H:i:s';

    public static function createReceipt(ReceiptRequest $request)
    {
        $receipt = new Receipt();
        $receipt->cash_box_id                             = $request->input('cash_box_id');
        $receipt->account_id                              = $request->input('account_id');
        $receipt->type_id                                 = $request->input('type_id');
        $receipt->balance                                 = $request->input('balance');
        $receipt->notes                                   = $request->input('notes');
        $receipt->created_by                              = User::activeUser()->id;

        if ($receipt->save())
        {
            return $receipt;
        }
        return null;
    } 



    public function updateReceipt(ReceiptRequest $request)
    {
        if (
            $this->cash_box_id        != $request->input('cash_box_id') ||
            $this->account_id         != $request->input('account_id') ||
            $this->balance            != $request->input('balance') )
        {
            $Journal = $this->getJournalEntry($this->type_id);
            $Journal->handelUpdateReceipt($this,$request);
        }

        $res = $this->update([
            'cash_box_id'   => $request->input('cash_box_id'),
            'account_id'    => $request->input('account_id'),
            'balance'       => $request->input('balance'),
            'notes'         => $request->input('notes'),
        ]);

        if($res == false)
        {
            throw new Exception('error_update_receipt',APP_ERROR);
        }

        return true;
    }


     /**
     * @throws Exception
     */
    public function handelDeleteReceipt(): bool
    {
        $this->getJournalEntry($this->type_id)->handelDeleteInvoice();

        if ($this->delete() == false)
        {
            throw new Exception('error_delete_invoice',APP_ERROR);
        }
        return true;
    }


    public function account(): HasOne
    {
        return $this->hasOne(Account::class,'id','account_id');
    }
    
    public function cashBox(): HasOne
    {
        return $this->hasOne(Account::class,'id','cash_box_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','created_by');
    }

    public function type(): HasOne
    {
        return $this->hasOne(ReceiptType::class,'id','type_id');
    }

    
    public function description(): string
    {
        
        if($this->type->id == RECEIPT_IN)
        {
            return 'ايصال استلام رقم('.$this->id.')';
        }
        return 'ايصال صرف رقم('.$this->id.')';
    }

    /**
     * @return Journal
     * return Invoice entry
     */
    public function getJournalEntry($type):Journal
    {
        return Journal::where('doc_id',$this->id)->where('doc_type_id',$type)->first();
    }
}
