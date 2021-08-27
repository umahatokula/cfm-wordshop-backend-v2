<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function order_details() {
        return $this->hasMany('App\Models\OrderDetail');
    }

    public function temp_download_links() {
        return $this->hasMany('App\Models\TempDownloadLink');
    }

    public function transaction() {
        return $this->hasOne('App\Models\Transaction');
    }


    /**
     * [generate description]
     * @return [type] [description]
    */
    public function generateOrderNumber() {

        // The length we want the unique reference number to be
        $orderNumber_length = 10;

        // A true/false variable that lets us know if we've found a unique reference number or not
        $orderNumber_found = false;

        // Define possible characters. Characters that may be confused such as the letter 'O' and the number zero aren't included
        $possible_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";

        // Until we find a unique reference, keep generating new ones
        while (!$orderNumber_found) {

        // Start with a blank reference number
        $orderNumber = "";

        // Set up a counter to keep track of how many characters have currently been added
        $i = 0;

        // Add random characters from $possible_chars to $orderNumber until $orderNumber_length is reached
        while ($i < $orderNumber_length) {

            // Pick a random character from the $possible_chars list
            $char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);

            $orderNumber .= $char;

            $i++;

        }

        // Our new unique reference number is generated. Lets check if it exists or not
        $result = Order::where('order_number', $orderNumber)->first();

        if (is_null($result)) {

            // We've found a unique number. Lets set the $orderNumber_found variable to true and exit the while loop
            $orderNumber_found = true;

        }

        return $orderNumber;

        }
    }
}
