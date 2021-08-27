<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\Order as OrderResource;

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
