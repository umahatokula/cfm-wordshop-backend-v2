@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Products</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">

    <!--Manage Product List Start-->
    <div class="col-12">
        <p>Success Purchases: {{ $transactions->count() }}</p>
        <br>
        <p>Downloads: {{ $number_of_messages }}</p>
    </div>
    <!--Manage Product List End-->

</div>
@endsection
