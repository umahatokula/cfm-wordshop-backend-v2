<?php

namespace App\Http\Controllers\Api;

use App\Mail\PreOrdered;
use App\Models\PreOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StorePreOrderRequest;

class PreOrderController extends Controller
{
    public function postOrder(StorePreOrderRequest $request) {
        // dd($request->all());

        $validated = $request->validated();

        $preOrder = PreOrder::create([
            'name' => $request['name'],
            'email' => $validated['email'],
        ]);

        Mail::to($validated['email'])->queue(new PreOrdered($preOrder));
    }
}
