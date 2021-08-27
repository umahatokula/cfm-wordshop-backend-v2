@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Add Preacher</h3>
        </div>
    </div><!-- Page Heading End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">
            <!-- Add or Edit Product Start -->
            <div class="add-edit-product-wrap col-12">

                <div class="add-edit-product-form">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($preachers as $preacher)
                        <tr>
                            <td scope="row">{{$loop->iteration}}</td>
                            <td>{{$preacher->name}}</td>
                            <td></td>
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
