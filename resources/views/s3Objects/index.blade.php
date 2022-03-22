@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>S3 Objects</h3>
        </div>
    </div><!-- Page Heading End -->

    <!-- Page Button Group Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="buttons-group">
            <a href="{{ route('s3objects.create') }}" class="button button-outline button-primary">Upload Sermon</a>
        </div>
    </div><!-- Page Button Group End -->

</div><!-- Page Headings End -->

<livewire:s3-objects.index>
@endsection
