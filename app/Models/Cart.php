<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model
{
    use HasFactory;
    
    /**
     * isExisting
     *
     * @return boolean
     */
    public static function isExisting() : bool {
        $userId = auth()->id();

        $cart = DB::table('shoppingcart')->where('identifier', $userId)->first();

        return $cart ? true : false;
    }
}
