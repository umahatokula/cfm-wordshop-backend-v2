<table class="table table-hover">
    <thead>
        <th class="text-left">Product</th>
        <th class="text-center">Qty</th>
        <th class="text-right">Price</th>
    </thead>
    @foreach ($order->order_details as $details)
        <tr>
            <td>{{ucwords($details->product->name)}}</td>
            <td class="text-center">{{$details->qty}}</td>
            <td class="text-right">{{number_format($details->price, 2)}}</td>
        </tr>
    @endforeach
    <tfoot>
        <td class="text-left"><b>Total:</b></td>
        <td colspan="2" class="text-right">{{number_format($order->order_details->sum('price'), 2)}}</td>
    </tfoot>
    
</table>