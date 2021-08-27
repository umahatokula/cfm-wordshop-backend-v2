<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;
use App\Models\TempDownloadLink;
use App\Mail\OrderPaid;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($customer_id = null)
    {
        if($customer_id) {
            $orders = Order::where('customer_id', $customer_id)->with('order_details')->orderBy('created_at', 'desc')->paginate();
        } else {
            $orders = Order::with('order_details')->orderBy('created_at', 'desc')->paginate();
        }


        if (request()->ajax()) {
            return response([
                'data' => new OrderCollection($orders)
            ], 200);
        }

        return view('orders.index')->with('orders', $orders);
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
    public function store(Request $request)
    {
        // dd($request->all());

    	$rules = [
            'order_details' => 'required',
            ];

            $messages = [
            'order_details.required' => 'Order cannot be empty',
            ];

            $this->validate($request, $rules, $messages);

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
                    $orderDetail->total_amount         = $detail['total_amount'];
                    $orderDetail->save();
                }

                if (request()->json()) {
                    return response([
                        'data' => new OrderCollection(Order::with('order_details.product')->paginate())
                    ], 200);
                }

                return redirect('orders');
            }

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

        if (request()->expectsJson()) {
            return $order;
            return response([
                'data' => new OrderResource($order)
            ], 200);
        }

        return view('orders.show')->with('order', $order);
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

    public function resendLinks($orderId) {
        $order = Order::findOrFail($orderId);

        if (!$order) {
          return;
        }

        foreach ($order->temp_download_links as $link) {
            // create temporary download link for products
            $link->temp_link = $link->product->getTempDownloadUrl();
            $link->save();
        }

        if ($order->email) {
            Mail::to($order->email)->queue(new OrderPaid($order->load('temp_download_links.product')));
        }

        return redirect()->back()->withSuccess('Links resent successfully');
    }
}
