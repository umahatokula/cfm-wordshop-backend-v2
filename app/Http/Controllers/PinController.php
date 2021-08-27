<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pin;

class PinController extends Controller
{
    public function listPins() {

        $data['pins'] = Pin::with('transactions')->get();

        return view('pins.listPins', $data);
    }

    /**
     * Create PINs Form
     */
    public function create() {

        return view('pins.create');
    }

    /**
     * Generate PINs
     */
    public function generatePINs(Request $request) {
        // dd($request->all());
    	$rules = [
            'number_to_generate' => 'required',
            'value' => 'required',
            ];
    
        $messages = [
            'number_to_generate.required' => 'Number to generate is required',
            'value.required' => 'Value of each PIN is required',
            ];
    
        $this->validate($request, $rules, $messages);

        for ($i=0 ; $i < $request->number_to_generate ; $i++) {
            $pin = new Pin;
            $pin->pin = $pin->generatePIN();
            $pin->value = $request->value;
            $pin->value_used = 0.00;
            $pin->is_printed = 0;
            $pin->is_exhausted = 0;
            $pin->save();
        }

        return redirect()->route('pins.listPins');
    }

    /**
     * Generate PINs
     */
    public function transactions($pin_id) {
        dd($request->all());

        $data['pin'] = Pin::where('id', $pin_id)->with('transactions')->first();

        return view('pins.transactions', $data);
    }
}