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

{{--<livewire:products.edit :product="$product">--}}


{!! Form::open([$product, 'route' => ['products.update', $product->id], 'method' => 'PUT', 'files' => true]) !!}

@if ($errors->any())
    <div class="row mb-5">
        <div class="col-12">
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="is_active">  Active/Inactive</label>
            </div>
            <div class="col-sm-9 col-12 mb-10">
                <div class="adomx-checkbox-radio-group">
                    <label class="adomx-checkbox-2">
                        {!! Form::checkbox('is_active', 1) !!} <i class="icon"></i> Active/Inactive</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="name">Name</label>
            </div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::text('name', $product->name,  ['class' => 'form-control', 'id' => 'name']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="sku">SKU</label>
            </div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::text('sku', $product->sku,  ['class' => 'form-control', 'id' => 'sku']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="description"> Description</label>
            </div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::text('description', $product->description,  ['class' => 'form-control', 'id' => 'description']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="unit_price"> Unit Price</label></div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::number('unit_price', $product->unit_price,  ['class' => 'form-control', 'id' => 'unit_price']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20 download_linkDiv">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="download_link"> Download Link</label></div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::text('download_link', $product->download_link,  ['class' => 'form-control', 'id' => 'download_link']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20 download_linkDiv">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="s3_key"> Object Key</label></div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::text('s3_key', $product->s3_key, ['class' => 'form-control', 'id' => 's3_key']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20" id="preacher_idDiv">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="preacher_id"> Preacher</label></div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::select('preacher_id', $preachers->pluck('name', 'id'), $product->preacher_id, ['class' => 'form-control', 'id' => 'preacher_id']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20" id="date_preachedDiv">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="preacher_id"> Date Preached</label></div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::date('date_preached', $product->date_preached, ['class' => 'form-control', 'id' => 'date_preached']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="categories"> Categories</label></div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::select('categories[]', $categories->pluck('name', 'id'), 1, ['class' => 'form-control', 'id' => 'categories', 'multiple']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="product_file"> Product File</label>
            </div>
            <div class="col-sm-9 col-12 mb-10">
                <!-- File Input -->
                {!! Form::file('product_file', $product->product_file, ['class' => 'form-control', 'id' => 'product_file']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 mb-20">
        <div class="row mbn-10">
            <div class="col-sm-3 col-12 mb-10"><label for="image"> Product Image</label>
            </div>
            <div class="col-sm-9 col-12 mb-10">
                {!! Form::file('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
            </div>
        </div>
    </div>

    <div class="col-12 mb-20">
        <input type="button" value="Cancel" class="button button-danger">
        <input type="submit" class="button button-primary" value="Save">
    </div>
</div>
{!! Form::close() !!}

@endsection
