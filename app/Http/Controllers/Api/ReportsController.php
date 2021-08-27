<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function index() {
        $transactions = Transaction::with('order')->where('status', 'success')->get();

        $number_of_messages = 0;
        foreach ($transactions as $transaction) {
            $number_of_messages += $transaction->order->order_details->count();
        }

        $data['transactions'] = $transactions;
        $data['number_of_messages'] = $number_of_messages;

        return view('reports.index', $data);
    }
}
