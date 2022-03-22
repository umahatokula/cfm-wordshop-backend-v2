<?php

namespace App\Http\Controllers\Api;

use App\Models\Pin;
use App\Models\Order;
use App\Models\Wallet;
use App\Mail\OrderPaid;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TempDownloadLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{

    /**
     * Store a new PINPAY transaction
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pinPay(Request $request) {
        // dd($request->all());
        // printf( $request->bundles);
        // print_r($request->products);

        $rules = [
            'pin'   => 'required',
            'amount'   => 'required',
            'email' => 'required|email',
        ];

        $messages = [
            'pin.required' => 'Please enter a PIN',
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
        ];

        // $this->validate($request, $rules, $messages);

        $customer = Customer::where('email', $request->email)->first();
        if(!$customer) {
            $customer = new Customer;
        }
        $customer->email = $request->email;
        $customer->save();

        $isBundle = isset($request->bundles) ? count($request->bundles) > 1 ? 1 :0 : 0;

        // create order
        $order = new Order;
        $order->customer_id  = $request->customer_id;
        $order->email        = $request->email;
        $order->order_number = $order->generateOrderNumber();
        $order->amount       = $request->amount;
        $order->discount     = 0.00;
        $order->is_bundle    = $isBundle;
        $order->pin_pay      = 1;
        $order->save();

        // order details for bundles
        if(count($request->bundles) > 0) {

            foreach ($request->bundles as $bundle) {

                foreach ($bundle['products'] as $product) {
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $product['id'];
                    $orderDetail->total_amount = $product['unit_price'];
                    $orderDetail->save();
                }

                // attach bundle and products to this order. It is important to save the products againts this order because the prices of products may change in the future. We want the price as at when this order was made
                $order->bundles()->attach($bundle['bundle_id'], ['products' => json_encode($bundle['products'])]);
            }

        } 

        // order details for products
        if(count($request->products) > 0) {
            foreach ($request->products as $product) {
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product['id'];
                $orderDetail->qty = $product['order_qty'];
                $orderDetail->total_amount = $product['unit_price'] * $product['order_qty'];
                $orderDetail->save();            
            }
        }  

        $requestPin = str_pad($request->pin, env('PIN_LENGTH'), '0', STR_PAD_LEFT);
        $pin = Pin::where('pin', $requestPin)->first();

        // pin not found
        if (!$pin) {
            //record trx
            $trx = new Transaction;
            $trx->trxref          = time().uniqid(mt_rand(),true);
            $trx->transaction     = $trx->generateTrxNumber();
            $trx->message         = 'PIN not found';
            $trx->status          = 'failed';
            $trx->payment_type_id = 1;
            $trx->order_id        = $order->id;
            $trx->amount          = $request->amount;
            $trx->save();

            $data = [
                'success' => false, 
                'message' => 'Invalid PIN', 
                'transaction' => $trx->transaction
            ];
            
            return response()->json($data, 200);
        }

        $remainingValue = $pin->value - $pin->value_used;

        // insufficient fund
        if ($remainingValue < $request->amount) {
            //record trx
            $trx = new Transaction;
            $trx->trxref          = time().uniqid(mt_rand(),true);
            $trx->transaction     = $trx->generateTrxNumber();
            $trx->message         = 'Insufficient fund. Ticket has '.$remainingValue.' units left';
            $trx->status          = 'failed';
            $trx->payment_type_id = 1;
            $trx->pin_id          = $pin->id;
            $trx->order_id        = $order->id;
            $trx->amount          = $request->amount;
            $trx->save();

            $data = [
                'success' => false, 
                'message' => 'Insufficient fund. Ticket has '.$remainingValue.' units left', 
                'transaction' => $trx->transaction
            ];
            return response()->json($data, 200);
        }

        // deduct amount on PIN
        $pin->value_used += $request->amount;
        $pin->is_exhausted = ($pin->value_used - $pin->value) <= 0 ? 1 : 0;
        $pin->save();

        //record trx
        $trx = new Transaction;
        $trx->trxref          = time().uniqid(mt_rand(),true);
        $trx->transaction     = $trx->generateTrxNumber();
        $trx->message         = 'Approved';
        $trx->status          = 'success';
        $trx->payment_type_id = 1;
        $trx->pin_id          = $pin->id;
        $trx->order_id        = $order->id;
        $trx->amount          = $request->amount;
        $trx->save();

        // indicate that order was fulfilled
        $order->is_fulfilled = 1;
        $order->save();

        // update product
        if(count($request->bundles) > 0) {
            foreach ($request->bundles as $bundle) {
                foreach ($bundle['products'] as $product) {
                    $p = Product::find($product['id']);
                    if (!$p->is_digital) {
                        $p->units_in_stock -= 1;
                        $p->units_on_order -= 1;
                        $p->is_fulfilled = 1;
                        $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
                    }
                    $p->save();
                    
                    // create temporary download link for product
                    $link = new TempDownloadLink;
                    $link->product_id = $p->id;
                    $link->order_id = $order->id;
                    $link->temp_link = $p->getTempDownloadUrl();
                    $link->save();
                }
            }
        }

        if(count($request->products) > 0) {
            foreach ($request->products as $product) {
                $p = Product::find($product['id']);
                if (!$p->is_digital) {
                    $p->units_in_stock -= 1;
                    $p->units_on_order -= 1;
                    $p->is_fulfilled = 1;
                    $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
                }
                $p->save();
                
                // create temporary download link for product
                $link = new TempDownloadLink;
                $link->product_id = $p->id;
                $link->order_id = $order->id;
                $link->temp_link = $p->getTempDownloadUrl();
                $link->save();
            }
        }

        Mail::to($request->email)->queue(new OrderPaid($order->load('temp_download_links.product')));

        $data = [
            'status' => true, 
            'message' => 'Transaction Successful', 
            'transaction' => $trx->transaction,
            'order' => $trx->load('order'),
        ];
        return response()->json($data, 200);
    }
    
    /**
     * Store a new OnlinePAY transaction
     *
     * @param  mixed $request
     * @return void
     */
    public function onlinePay(Request $request) {
        // dd($request->all());

        // create order
        $order = new Order;
        $order->email        = $request->email;
        $order->customer_id  = $request->customer_id;
        $order->order_number = $order->generateOrderNumber();
        $order->amount       = $request->amount;
        $order->discount     = 0.00;
        $order->is_bundle    = count($request->bundles) > 0 ? 1 : 0;
        $order->online_pay   = 1;
        $order->save();

        // order details for bundles
        if(count($request->bundles) > 0) {
            foreach ($request->bundles as $bundle) {
                foreach ($bundle['products'] as $product) {
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $product['id'];
                    $orderDetail->total_amount = $product['unit_price'];
                    $orderDetail->save();
                }
            }
        }

        // order details for products
        if(count($request->products) > 0) {
            foreach ($request->products as $product) {
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product['id'];
                $orderDetail->qty = $product['order_qty'];
                $orderDetail->total_amount = $product['unit_price'] * $product['order_qty'];
                $orderDetail->save();            
            }
        }        

        //record trx
        $trx = new Transaction;
        $trx->trxref = $request->trxref;
        $trx->transaction = $request->transaction;
        $trx->message = $request->message;
        $trx->status = $request->status;
        $trx->payment_type_id = 2;
        $trx->order_id = $order->id;
        $trx->amount = $request->amount;
        $trx->save();

        // indicate that order was fulfilled
        $order->is_fulfilled = 1;
        $order->save();

        // update product if bundle
        
        if(count($request->bundles) > 0) {
            foreach ($request->bundles as $bundle) {
                foreach ($bundle['products'] as $product) {
                    $p = Product::find($product['id']);
                    if (!$p->is_digital) {
                        $p->units_in_stock -= 1;
                        $p->units_on_order -= 1;
                        $p->is_fulfilled = 1;
                        $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
                    }
                    $p->save();
                    
                    // create temporary download link for product
                    $link = new TempDownloadLink;
                    $link->product_id = $p->id;
                    $link->order_id = $order->id;
                    $link->temp_link = $p->getTempDownloadUrl();
                    $link->save();
                }
            }
        }

        if(count($request->products) > 0) {
            foreach ($request->products as $product) {
                $p = Product::find($product['id']);
                if (!$p->is_digital) {
                    $p->units_in_stock -= 1;
                    $p->units_on_order -= 1;
                    $p->is_fulfilled = 1;
                    $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
                }
                $p->save();
                
                // create temporary download link for product
                $link = new TempDownloadLink;
                $link->product_id = $p->id;
                $link->order_id = $order->id;
                $link->temp_link = $p->getTempDownloadUrl();
                $link->save();
            }
        }

        Mail::to($request->email)->queue(new OrderPaid($order->load('temp_download_links.product')));

        $data = ['status' => true, 'message' => 'Transaction Successful', 'transaction' => $trx->transaction];
        
        return response()->json($data, 200);

    }
    
    /**
     * Store a new WalletPAY transaction
     *
     * @param  mixed $request
     * @return void
     */
    public function walletPay(Request $request) {
        // dd($request->all());

        $user = auth()->user();

        // create order
        $order = new Order;
        $order->email        = $request->email;
        $order->customer_id  = $request->customer_id;
        $order->order_number = $order->generateOrderNumber();
        $order->amount       = $request->amount;
        $order->discount     = 0.00;
        $order->is_bundle    = count($request->bundles) > 0 ? 1 : 0;
        $order->wallet_pay   = 1;
        $order->save();

        // order details for bundles
        if(count($request->bundles) > 0) {
            foreach ($request->bundles as $bundle) {
                foreach ($bundle['products'] as $product) {
                    $orderDetail = new OrderDetail;
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $product['id'];
                    $orderDetail->total_amount = $product['unit_price'];
                    $orderDetail->save();
                }
            }
        }

        // order details for products
        if(count($request->products) > 0) {
            foreach ($request->products as $product) {
                $orderDetail = new OrderDetail;
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $product['id'];
                $orderDetail->qty = $product['order_qty'];
                $orderDetail->total_amount = $product['unit_price'] * $product['order_qty'];
                $orderDetail->save();            
            }
        }
        
        // check wallet balance
        $walletBalance = $user->wallet ? $user->wallet->balance : 0;
        if($walletBalance < $request->amount) {
            
            $trx = new Transaction;
            $trx->trxref          = $request->trxref;
            $trx->transaction     = $trx->generateTrxNumber();
            $trx->message         = 'Insufficient funds in wallet';
            $trx->status          = 'failed';
            $trx->payment_type_id = 1;
            $trx->order_id        = $order->id;
            $trx->amount          = $request->amount;
            $trx->save();

            $data = ['status' => false, 'message' => 'Insufficient funds in wallet', 'transaction' => $trx->transaction];
            return response()->json($data, 200);
        }

        //record trx
        $trx = new Transaction;
        $trx->trxref          = $request->trxref;
        $trx->transaction     = $trx->generateTrxNumber();
        $trx->message         = 'Approved';
        $trx->status          = 'success';
        $trx->payment_type_id = 3;
        $trx->order_id        = $order->id;
        $trx->amount          = $request->amount;
        $trx->save();

        // indicate that order was fulfilled
        $order->is_fulfilled = 1;
        $order->save();
        
        if(count($request->bundles) > 0) {
            foreach ($request->bundles as $bundle) {
                foreach ($bundle['products'] as $product) {
                    $p = Product::find($product['id']);
                    if (!$p->is_digital) {
                        $p->units_in_stock -= 1;
                        $p->units_on_order -= 1;
                        $p->is_fulfilled = 1;
                        $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
                    }
                    $p->save();
                    
                    // create temporary download link for product
                    $link = new TempDownloadLink;
                    $link->product_id = $p->id;
                    $link->order_id = $order->id;
                    $link->temp_link = $p->getTempDownloadUrl();
                    $link->save();
                }
            }
        }

        if(count($request->products) > 0) {
            foreach ($request->products as $product) {
                $p = Product::find($product['id']);
                if (!$p->is_digital) {
                    $p->units_in_stock -= 1;
                    $p->units_on_order -= 1;
                    $p->is_fulfilled = 1;
                    $p->is_available  = $p->units_in_stock > 0 ? 1 : 0;
                }
                $p->save();
                
                // create temporary download link for product
                $link = new TempDownloadLink;
                $link->product_id = $p->id;
                $link->order_id = $order->id;
                $link->temp_link = $p->getTempDownloadUrl();
                $link->save();
            }
        }

        // debit wallet
        $user->wallet->debit($request->amount);

        Mail::to($request->email)->queue(new OrderPaid($order->load('temp_download_links.product')));

        $data = ['status' => true, 'message' => 'Transaction Successful', 'transaction' => $trx->transaction];
        return response()->json($data, 200);

    }
}
