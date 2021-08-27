<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details($order_number)
    {
        dd($order_number);
        $orderDetails = Order::with('order_details')->where('order_number', $order_number)->first();
        dd($orderDetails);
        if (request()->expectsJson()) {
            // return new OrderCollection($orderDetails);
            return response([
                'data' => new OrderCollection($orderDetails)
            ], 200);
        }

        $data['orderDetails'] = $orderDetails;

        return view('orders.details', $data);
    }
}
