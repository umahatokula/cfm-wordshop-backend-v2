<div>
    <div class="row my-3">
        <div class="col-12">
            <input class="form-control" type="text" wire:model="search" placeholder="Search by trxn no">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-light">
                <thead class="thead-light">
                    <tr>
                        <th>Trxn No</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>PIN</th>
                        <th>Message</th>
                        <th>Order</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction }}</td>
                        <td>{{ $transaction->order ? $transaction->order->email : '' }}</td>
                        <td>{{ number_format($transaction->amount, 2) }}</td>
                        <td wire:click="showPinDetails">{{ $transaction->pin ? $transaction->pin->pin : '' }}</td>
                        <td>{{ $transaction->message }}</td>
                        <td><a href="#" wire:click.prevent="showOrder(1)">{{ $transaction->order->order_number }}</a></td>
                        <td>{{ $transaction->created_at->toDateTimeString() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12 text-center">
            {{ $transactions->links() }}
        </div>
    </div>

</div>
