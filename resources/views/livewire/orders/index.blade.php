<div>
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif
    <div class="row my-3">
        <div class="col-12">
            <input class="form-control" type="text" wire:model="search" placeholder="Search by order number">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-vertical-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>PIN</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Resend</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                    <td>{{$order->order_number}}</td>
                        <td>{{$order->email}}</td>
                        <td>{{number_format($order->amount, 2)}}</td>
                        <td wire:click="showPinDetails">
                            @if($order->transaction)
                                {{ $order->transaction->pin ? $order->transaction->pin->pin : '' }}
                            @endif
                        </td></td>
                        <td>{{$order->created_at}}</td>
                        <td><span class="badge badge-{{$order->is_fulfilled?'success':'danger'}}">{{$order->is_fulfilled?'fulfilled':'pending'}}</span></td>
                        <td>
                            <a class="" href="{{route('orders.resendLinks', $order->id)}}">Resend Link</a>
                        </td>
                        <td class="action h4">
                            <div class="table-action-buttons">
                                <a class="view button button-box button-xs button-primary"  data-toggle="modal"
                                data-target="#modal"
                                data-remote="{{route('orders.show', $order->id)}}" href="#"><i class="zmdi zmdi-eye"></i></a>

                                <a class="edit button button-box button-xs button-warning" href="{{route('orders.details', $order->id)}}"><i class="zmdi zmdi-more"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-center">
            {{ $orders->links() }}
        </div>
    </div>

</div>
