<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class JournalEntryCredit
 * @package App\Models
 *
 * @property integer $id
 * @property integer $balance
 * @property integer $account_id
 * @property integer $journal_id
 *
 * RELATIONS PROPERTIES
 *
 * @property Account  $account
 *
 */
class JournalEntryCredit extends Model
{
    use HasFactory;

    protected $fillable =[
        'balance',
        'account_id',
        'journal_id',
    ];

    public function account(): HasOne
    {
        return $this->hasOne(Account::class,'id','account_id');
    }

    public function journal(): HasOne
    {
        return $this->hasOne(Journal::class,'id','journal_id');
    }
}
