@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Order Details</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">

            <div class="row mbn-30">

                <!--Order Details Head Start-->
                <div class="col-12 mb-30">
                    <div class="row mbn-15 shadow-sm">
                        <div class="col-12 col-md-4 mb-15">
                            <h4 class="text-primary fw-600 m-0">#{{$order->order_number}}</h4>
                        </div>
                        <div class="text-left text-md-center col-12 col-md-4 mb-15"><span>Status: <span
                                    class="badge badge-round badge-{{$order->is_fulfilled ? 'success' : 'warning'}}">{{$order->is_fulfilled ? 'Fulfilled' : 'Pending'}}</span></span>
                        </div>
                        <div class="text-left text-md-right col-12 col-md-4 mb-15">
                            <p>{{$order->created_at->toFormattedDateString()}}</p>
                        </div>
                    </div>
                </div>
                <!--Order Details Head End-->

                <!--Order Details Customer Information Start-->
                <div class="col-12 mb-30">
                    <div class="order-details-customer-info row mbn-20">

                        <!--Purchase Info Start-->
                        <div class="col-lg-4 col-md-6 col-12 mb-20">
                            <div class="card border-dark">
                                <div class="card-body">
                                    <h4 class="mb-25">Purchase Info</h4>
                                    <ul>
                                        <li> <span>Items</span> <span>{{$order->order_details->sum('qty')}}</span> </li>
                                        <li> <span>Price</span> <span>{{$order->order_details->sum('price')}}</span> </li>
                                        <li> <span>Discount</span> <span>{{$order->discount}}</span> </li>
                                        <li> <span>Total</span> <span>{{$order->order_details->sum('price') - $order->discount}}</span> </li>
                                    <li> <span class="h5 fw-600">Type</span> <span class="h5 fw-600 text-{{$order->is_paid ? 'success' : 'danger'}}">{{$order->is_paid ? 'paid' : 'failed'}}</span> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--Purchase Info End-->

                        <!--Items Start-->
                        <div class="col-lg-8 col-md-12 mb-20">
                            <div class="row">
                                <div class="col-12 mb-5">
                                    <div class="">
                                        <a href="#" data-toggle="modal" data-target="#modal" data-remote="{{route('orders.show', $order->id)}}"  class="btn btn-sm btn-primary">Transaction</a>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <h4 class="mb-25">Order Items</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-vertical-middle">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th class="text-center">Quentity</th>
                                                    <th class="text-right">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->order_details as $detail)
                                                <tr>
                                                    <td><a href="#">{{ucfirst($detail->product->name)}}</a></td>
                                                    <td class="text-center">{{$detail->qty}}</td>
                                                    <td class="text-right">{{number_format($detail->price, 2)}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <td><b>Total</b></td>
                                                <td colspan="2" class="text-right">
                                                    <b>{{number_format($order->order_details->sum('price'), 2)}}</b>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Items End-->

                    </div>
                </div>
                <!--Order Details Customer Information Start-->

            </div>
        </div>
    </div>
</div>
@endsection
