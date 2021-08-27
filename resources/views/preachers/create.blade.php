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
                    {!! Form::open(['route' => 'preachers.store']) !!}
                        <div class="row mbn-20">

                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="name">Name</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name',
                                        'placeholder' => 'Name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <input type="submit" value="submit" class="button button-primary">
                                <input type="submit" value="Cancel" class="button button-danger">
                            </div>

                        </div>
                    {!! Form::close() !!}
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
