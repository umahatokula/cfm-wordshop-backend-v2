<table class="table">
    <thead>
        <tr>
        <th colspan="3" class="text-center"><b>{{$pin->pin}}</b></th>
        </tr>
        <tr>
            <th>Order</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pin->transactions as $transaction)
        <tr>
            <td>{{ $transactions }}</td>
            <td>sdsd</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>
