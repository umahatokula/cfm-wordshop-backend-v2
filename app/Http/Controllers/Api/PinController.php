<?php

namespace App\Http\Controllers\Api;

use App\Models\Pin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pin as PinResource;

class PinController extends Controller
{    
    /**
     * Get pin balance
     *
     * @param  mixed $pin
     * @return void
     */
    public function balance($pin = null) {

        if ($pin) {
            $pin= Pin::where('pin', $pin)->first();
        }
        
        return response()->json([
            'status' => true,
            'data' => (!$pin ? 'Please enter a PIN' : ($pin ? new PinResource($pin) : 'PIN not found')),
        ]);
    }
        
    /**
     * Check if pin is valid
     *
     * @param  mixed $pin
     * @return void
     */
    public function isValid($pin = null) {
        
        return response()->json([
            'status' => true,
            'data' => Pin::where('pin', $pin)->first() ? true : false,
        ]);
    }
}