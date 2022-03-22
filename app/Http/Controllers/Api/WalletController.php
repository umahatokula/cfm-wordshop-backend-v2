<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WalletGatewayResponse;
use App\Models\WalletTransaction as WalletTransactionModel;

class WalletController extends Controller
{
    public function walletTransactions() {

        return response()->json([
            'status' => true,
            'transactions' => auth()->user()->walletTransactions,
            'balance' => auth()->user()->walletTransactions->sum('amount'),
            'used' => abs(auth()->user()->walletTransactions->where('type', 'dr')->sum('amount')),
        ]);
        
    }

    public function fund() {
        // dd(request('transaction')['message']);

        // record transaction
        WalletGatewayResponse::create([
            'message'     => request('transaction')['message'],
            'redirecturl' => request('transaction')['redirecturl'],
            'reference'   => request('transaction')['reference'],
            'status'      => request('transaction')['status'],
            'trans'       => request('transaction')['trans'],
            'transaction' => request('transaction')['transaction'],
            'trxref'      => request('transaction')['trxref'],
        ]);

        // debit wallet
        $amount = request('wallet')['amount'];

        $wallet = Wallet::firstOrNew(['customer_id' =>  auth()->id()]);
        $wallet->credit($amount, request('transaction')['reference']);

        return response([
            'status' => true,
            'message' => 'Successfully debited your account'
        ], 200);
    }

    
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
            'status' => true,
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
            'status' => true,
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

        $wallet = Wallet::updateOrCreate(
            ['customer_id' => Auth::id()],
            ['units' => $debit + $balance]
        );

        return response([
            'status' => true,
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
            'status' => true,
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
           'status' => true,
           'balance' => $balance
        ], 200);
    }
}
