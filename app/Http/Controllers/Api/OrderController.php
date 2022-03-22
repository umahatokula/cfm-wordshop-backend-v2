<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use App\Mail\OrderPaid;
use App\Models\OrderDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TempDownloadLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\OrderCollection;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $orders = Order::with(['order_details.product.preacher', 'user', 'bundles', 'customer'])->orderBy('created_at', 'desc')->get();

        return response([
            'status' => true,
            'data' => $orders
        ], 200);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myOrders() {

        $user = auth()->user();

        if (!$user ) {
            abort();
        }

        $orders = Order::where('customer_id', $user->id)->orWhere('email', $user->email)->with(['order_details.product.preacher', 'user', 'bundles', 'customer'])->orderBy('created_at', 'desc')->get();

        return response([
            'status' => true,
            'data' => $orders
        ], 200);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($order_number)
    {
        $order = Order::where('order_number', $order_number)->with('customer', 'transaction', 'order_details.product')->first();

        if($order) {
            return response([
                'status' => true,
                'data' => $order
            ], 200);
        } else {
            return response([
                'success' => false,
                'data' => $order
            ], 200);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadlinks ($transaction_number) {
        $transaction = Transaction::with('order.order_details.product.preacher')->where('transaction', $transaction_number)->first();

        if (!$transaction) {
            return;
        }

        $order = $transaction->order;
        if (!$order) {
            return;
        }

        $products = TempDownloadLink::with('product.preacher')->where('order_id', $order->id)->get();

        return response()->json([
            'transaction' => $transaction,
            'products' => $products,
        ]);

    }
}
