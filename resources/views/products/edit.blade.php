@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Edit Product</h3>
        </div>
    </div><!-- Page Heading End -->

    <!-- Page Button Group Start -->

</div><!-- Page Headings End -->


@livewire('products.edit', ['product' => $product, 'preachers' => $preachers, 'categories' => $categories])

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
