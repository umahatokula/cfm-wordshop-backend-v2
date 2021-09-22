<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletGatewayResponse extends Model
{
    use HasFactory;

    protected $fillable  = [
        'message',
        'redirecturl',
        'reference',
        'status',
        'trans',
        'transaction',
        'trxref'
    ];
}
