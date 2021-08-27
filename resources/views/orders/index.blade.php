@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Orders</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">

    <!--Order List Start-->
    <div class="col-12">
        <livewire:orders.index />
    </div>
    <!--Order List End-->

</div>
@endsection
