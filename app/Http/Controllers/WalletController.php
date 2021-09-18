<?php

namespace App\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $wallets = Wallet::all();

        return response([
            'success' => true,
            'wallets' => $wallets
         ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $wallet = Wallet::create([
            'customer_id' => $request->customer_id,
            'units' => 0,
        ]);

        return response([
            'success' => true,
            'message' => 'Wallet created successfully'
         ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function debit(Request $request, $id)
    {
        //
        $wallet = Wallet::findOrFail($request->customer_id);
        $balance = $wallet->units;
        $debit = $request->amount;
        $wallet->units = $debit + $balance;
        $wallet->save();
        return response([
            'success' => true,
            'message' => 'Successfully debited your account'
         ], 200);
    }

    public function credit(Request $request, $id)
    {
        //
        $wallet = Wallet::findOrFail($request->customer_id);
        $balance = $wallet->units;
        $debit = $request->amount;
        $wallet->units = $debit + $balance;
        $wallet->save();

        return response([
            'success' => true,
            'message' => 'Successfully credited your account'
         ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function showBalance(Wallet $wallet, Request $request, $id)
    {
        //
        $wallet = Wallet::findOrFail($request->user_id);
        $balance = $wallet->units;
        return response([
           'success' => true,
           'balance' => $balance
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
