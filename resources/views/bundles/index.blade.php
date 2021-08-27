@extends('master')

@section('body')

<!-- Page Headings Start -->
<div class="row justify-content-between align-items-center mb-10">

    <div class="col-12 col-lg-auto mb-20">
        <div class="page-heading">
            <h3>Bundles</h3>
        </div>
    </div><!-- Page Heading End -->

    <!-- Page Button Group Start -->
    <div class="col-12 col-lg-auto mb-20">
        <div class="buttons-group">
            <a href="{{ route('bundles.create') }}" class="button button-outline button-primary">Add Bundle</a>
        </div>
    </div><!-- Page Button Group End -->

</div><!-- Page Headings End -->

<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="box">
            <div class="box-body">
            
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Bundle</th>
                            <th>Price</th>
                            <th class="text-center">Number of Items in Bundle</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bundles as $bundle)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td>{{$bundle->name}}</td>
                            <td>{{$bundle->price}}</td>
                            <td class="text-center">{{$bundle->products->count()}}</td>
                            <td class="text-center">
                                <span class="badge badge-outline badge-{{$bundle->is_active ? 'primary' : 'danger'}}">{{$bundle->is_active ? 'active' : 'inactive'}}</span>
                            </td>
                            <td class="text-center">

                                <a data-href="#" data-clipboard-text="zmdi zmdi-edit" data-toggle="modal"
                                    data-target="#modal"
                                    data-remote="{{route('bundles.show', $bundle->id)}}"><i
                                        class="text-info zmdi zmdi-eye zmdi-hc-fw"></i></a>

                                <a data-href="#" data-clipboard-text="zmdi zmdi-edit" data-toggle="modal"
                                    data-target="#modal"
                                    data-remote="{{route('bundles.edit', $bundle->id)}}"><i
                                        class="text-primary zmdi zmdi-edit zmdi-hc-fw"></i></a>

                                <a data-href="{{route('bundles.delete', $bundle->id)}}"
                                    data-clipboard-text="zmdi zmdi-delete" data-toggle="modal"
                                    data-target="#confirmationModal"><i
                                        class="text-danger zmdi zmdi-delete zmdi-hc-fw"></i></a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
