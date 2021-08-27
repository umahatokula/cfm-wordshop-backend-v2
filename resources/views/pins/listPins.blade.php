@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>PIN Mananagement</h3>
        </div>
    </div><!-- Page Heading End -->

    <!-- Page Button Group Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="buttons-group">
            <a data-toggle="modal"
            data-target="#modal"
            data-remote="{{route('pins.create')}}" href="#" class="button button-primary">Generate PINs</a>
        </div>
    </div><!-- Page Button Group End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th>PIN</th>
                        <th class="text-right">PIN Units</th>
                        <th class="text-right">Units Used</th>
                        <th class="text-right">Available Units</th>
                        <th class="text-center">Action(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pins as $pin)
                    <tr>
                        <td scope="row">{{$pin->pin}}</td>
                        <td class="text-right">{{number_format($pin->value, 2)}}</td>
                        <td class="text-right">{{number_format($pin->value_used, 2)}}</td>
                        <td class="text-right">{{number_format($pin->value - $pin->value_used, 2)}}</td>
                        <td class="text-center">
                            <a data-toggle="modal"
                            data-target="#modal"
                            data-remote="{{route('pins.transactions', $pin->id)}}" href="#" class="btn btn-success">View PIN Transactions</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
