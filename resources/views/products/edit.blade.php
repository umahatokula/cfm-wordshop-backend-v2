@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Add Product</h3>
        </div>
    </div><!-- Page Heading End -->

    <!-- Page Button Group Start -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">
            <!-- Add or Edit Product Start -->
            <div class="add-edit-product-wrap col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="add-edit-product-form">
                    {!! Form::model($product, ['route' => ['products.update', $product->id], 'files' => true, 'method' => 'PUT']) !!}
                        <div class="row mbn-20">

                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="name">Active/Inactive</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::checkbox('is_active', $product->is_active, ['class' => 'custom-control-input', 'id' => 'is_active']) !!}
                                    </div>
                                </div>
                            </div>

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
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="sku">SKU</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('sku', null, ['class' => 'form-control', 'id' => 'sku',
                                        'placeholder' => 'SKU']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="description"> Description</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('description', null, ['class' => 'form-control', 'id' =>
                                        'description', 'placeholder' => 'Description']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="unit_price"> Unit Price</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('unit_price', null, ['class' => 'form-control', 'id' =>
                                        'unit_price', 'placeholder' => 'Unit Price']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="discount_price"> Discount
                                            Price</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('discount_price', '0.00', ['class' => 'form-control', 'id' =>
                                        'discount_price', 'placeholder' => 'Discount Price']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="is_digital">  Is this product Digital?</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input value="{{$product->is_digital}}" name="is_digital" id="is_digital" type="checkbox"> <i
                                                    class="icon"></i> Is Digital</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20 download_linkDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="download_link"> Download Link</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('download_link', $product->download_link, ['class' => 'form-control', 'id' =>
                                        'download_link', 'placeholder' => 'Download Link']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20 download_linkDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="s3_key"> Object Key</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::text('s3_key', $product->s3_key, ['class' => 'form-control', 'id' =>
                                        's3_key', 'placeholder' => 'Object Key']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="is_audio"> Is this product Audio?</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input value="{{$product->is_audio}}" name="is_audio" id="is_audio" type="checkbox"> <i class="icon"></i> Audio?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20" id="quantity_per_unitDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="quantity_per_unit"> Quantity per
                                            Unit</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::number('quantity_per_unit', null, ['class' => 'form-control ', 'id' =>
                                        'quantity_per_unit', 'placeholder' => 'Quantity per Unit']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20" id="units_in_stockDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="units_in_stock"> Units in
                                            stock</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::number('units_in_stock', null, ['class' => 'form-control', 'id' =>
                                        'units_in_stock', 'placeholder' => 'Units in stock']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20" id="reorder_levelDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="reorder_level"> Re-order Level</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::number('reorder_level', null, ['class' => 'form-control', 'id' =>
                                        'reorder_level', 'placeholder' => 'Units in stock']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20" id="preacher_idDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="preacher_id"> Preacher</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::select('preacher_id', $preachers, null, ['class' => 'form-control', 'id' =>
                                        'preacher_id', 'placeholder' => 'Preacher']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20" id="date_preachedDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="preacher_id"> Date Preached</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::date('date_preached', null, ['class' => 'form-control', 'id' =>
                                        'date_preached', 'placeholder' => 'Date Preached']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="categories"> Categories</label></div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        {!! Form::select('categories[]', $categories, null, ['class' => 'form-control',
                                        'id' => 'categories', 'placeholder' => 'Categories', 'multiple']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="is_taxable"> Is taxable</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input value="{{$product->is_discountable}}" name="is_taxable" id="is_taxable" type="checkbox"> <i
                                                    class="icon"></i>
                                                Is taxable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="is_discountable"> Is
                                            Discountable</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input value="{{$product->is_discountable}}" name="is_discountable" id="is_discountable" type="checkbox"> <i
                                                    class="icon"></i>
                                                Is Discountable</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="image"> Product Image</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input name="image" class="dropify" type="file" data-height="220">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20" id="downloadable_fileDiv">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10"><label for="image"> Downloadable File</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <div class="adomx-checkbox-radio-group">
                                            <label class="adomx-checkbox-2">
                                                <input name="downloadable_file" class="dropify" type="file" data-height="220">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-20">
                                <input type="submit" value="submit" class="button button-primary">
                                <input type="submit" value="cancle" class="button button-danger">
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

$( document ).ready(function() {
        if($('#preacher_idDiv').is(":visible")){
            $("#preacher_idDiv").css("display", "none");
        } else {
            $("#preacher_idDiv").css("display", "block");
        }

        if($('#date_preachedDiv').is(":visible")){
            $("#date_preachedDiv").css("display", "none");
        } else {
            $("#date_preachedDiv").css("display", "block");
        }

        if($('#downloadable_fileDiv').is(":visible")){
            $("#downloadable_fileDiv").css("display", "none");
        } else {
            $("#downloadable_fileDiv").css("display", "block");
        }

        if($('.download_linkDiv').is(":visible")){
            $(".download_linkDiv").css("display", "none");
        } else {
            $(".download_linkDiv").css("display", "block");
        }
});

$( "#is_digital" ).on( "click", function() {
    // $('#quantity_per_unit').attr('disabled', function(_, attr){ return !attr});
    // $('#units_in_stock').attr('disabled', function(_, attr){ return !attr});
    // $('#reorder_level').attr('disabled', function(_, attr){ return !attr});
    $('#quantity_per_unitDiv').toggle();
    $('#units_in_stockDiv').toggle();
    $('#reorder_levelDiv').toggle();

        if($('#preacher_idDiv').is(":visible")){
            // $('#preacher_idDiv').hide();
            $("#preacher_idDiv").css("display", "none");
        } else {
            // $('#preacher_idDiv').show();
            $("#preacher_idDiv").css("display", "block");
        }

        if($('#date_preachedDiv').is(":visible")){
            $("#date_preachedDiv").css("display", "none");
        } else {
            $("#date_preachedDiv").css("display", "block");
        }

        if($('#downloadable_fileDiv').is(":visible")){
            $("#downloadable_fileDiv").css("display", "none");
        } else {
            $("#downloadable_fileDiv").css("display", "block");
        }

        if($('.download_linkDiv').is(":visible")){
            $(".download_linkDiv").css("display", "none");
        } else {
            $(".download_linkDiv").css("display", "block");
        }

});
</script>
@endsection
