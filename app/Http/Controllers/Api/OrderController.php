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
use App\Http\Resources\Order as OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myOrders() {

        $user = auth()->user();

        $orders = Order::where('customer_id', $user->id)->orWhere('email', $user->email)->with(['order_details.product.preacher', 'user', 'bundles'])->orderBy('created_at', 'desc')->get();

        return response([
            'success' => true,
            'data' => $orders
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // dd($request->all());

        $validated = $request->validated();

        $order                  = new Order;
        $order->customer_id     = $request->customer_id;
        $order->order_number    = $order->generateOrderNumber();
        $order->amount          = $request->amount;
        $order->payment_id      = $request->payment_id;
        $order->error_msg       = $request->error_msg;


        if($order->save()) {

            foreach($request->order_details as $detail) {
                $orderDetail                = new OrderDetail;
                $orderDetail->order_id      = $order->id;
                $orderDetail->product_id    = $detail['product_id'];
                $orderDetail->qty           = $detail['qty'];
                $orderDetail->total_amount  = $detail['total_amount'];
                $orderDetail->save();
            }

            return response([
                'success' => true,
                'data' => new OrderCollection(Order::with('order_details.product')->paginate(20))
            ], 200);
        }

        return response([
            'success' => false
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
        $order = Order::where('order_number', $order_number)->with('transaction', 'order_details.product')->first();

        return response([
            'success' => true,
            'data' => $order
        ], 200);

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
