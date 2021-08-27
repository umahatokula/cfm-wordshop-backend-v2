<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $hidden = array('created_at', 'deleted_at', 'updated_at');

    public function order() {
        return $this->belongsTo('App\Models\Order');
    }

    public function pin() {
        return $this->belongsTo('App\Models\Pin');
    }


    /**
     * [generate trx number]
     * @return [type] [description]
    */
    public function generateTrxNumber() {

        // The length we want the unique reference number to be
        $trxNumber_length = 10;

        // A true/false variable that lets us know if we've found a unique reference number or not
        $trxNumber_found = false;

        // Define possible characters. Characters that may be confused such as the letter 'O' and the number zero aren't included
        $possible_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

        // Until we find a unique reference, keep generating new ones
        while (!$trxNumber_found) {

        // Start with a blank reference number
        $trxNumber = "";

        // Set up a counter to keep track of how many characters have currently been added
        $i = 0;

        // Add random characters from $possible_chars to $trxNumber until $trxNumber_length is reached
        while ($i < $trxNumber_length) {

            // Pick a random character from the $possible_chars list
            $char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);

            $trxNumber .= $char;

            $i++;

        }

        // Our new unique reference number is generated. Lets check if it exists or not
        $result = Transaction::where('transaction', $trxNumber)->first();

        if (is_null($result)) {

            // We've found a unique number. Lets set the $trxNumber_found variable to true and exit the while loop
            $trxNumber_found = true;

        }

        return $trxNumber;

        }
    }
}
