<?php

namespace App\Models;

use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'customer_id', 'balance',
    ];

    public function debit($amount, $reference) {

        $this->balance -= $amount;
        $this->save();

        $trxn = new WalletTransaction;
        $trxn->amount = $amount;
        $trxn->type = 'dr';
        $trxn->balance -= $amount;
        // $trxn->reference = $reference;
        $trxn->save();

        $this->transactions()->save($trxn);

        return $this;
    }

    public function credit($amount, $reference) {

        $this->balance += $amount;
        $this->save();

        $trxn = new WalletTransaction;
        $trxn->amount = $amount;
        $trxn->type = 'cr';
        $trxn->balance += $amount;
        $trxn->reference = $reference;
        $trxn->save();

        $this->transactions()->save($trxn);

        return $this;
    }

    /**
     * Get all of the transactions for the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
