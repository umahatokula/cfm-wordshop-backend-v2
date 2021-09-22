@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3> Preorders</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <a href="{{ route('pre-order-type.create') }}" class="float-right btn btn-primary">Create Preorders</a>
    </div>
</div>

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">
            <!-- Add or Edit Product Start -->
            <div class="add-edit-product-wrap col-12">

                <div class="add-edit-product-form">
                <table class="table table-bordered table-dense">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($preorders as $preorder)
                        <tr>
                            <td scope="row">{{$loop->iteration}}</td>
                            <td>{{$preorder->name}}</td>
                            <td class="text-center">
                                <a data-toggle="modal"
                                data-target="#modal"
                                data-remote="{{route('pre-orders.details', $preorder)}}" href="#" class="btn btn-success">Details</a>
                                <a href="{{ route('pre-order-type.send-links', [$preorder]) }}" class="btn btn-primary">Send Links</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>

            </div><!-- Add or Edit Product End -->
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script>

</script>
@endsection
