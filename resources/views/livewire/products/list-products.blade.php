<div>
    <div class="row my-3">
        <div class="col-12">
            <input class="form-control" type="text" wire:model="search" placeholder="Search by name">
        </div>
    </div>
    <div class="row mb-5">

        <!--Manage Product List Start-->
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Preacher</th>
                            <th>Price</th>
                            <th>Date Preached</th>
                            <th>Status</th>
                            <th>Test Download</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td><a href="#">{{$product->name}} - ({{$product->no_of_downloads}})</a></td>
                            <td>
                                <img src="{{ $product->album_art }}" alt="" style="max-width: 30px">
                            </td>
                            <td><a href="#">{{$product->preacher ? $product->preacher->name : null}}</a></td>
                            <td>{{$product->unit_price}}</td>
                            <td>{{ $product->date_preached ?$product->date_preached->toFormattedDateString() : null }}</td>
                            <td>
                                <span class="badge badge-{{$product->is_active == 1 ? 'success' : 'danger'}}">{{$product->is_active == 1 ? 'active' : 'inactive'}}</span>
                            </td>
                            <td>
                                <a href="{{$product->getTempDownloadUrl()}}" target="_blank" download>Test Download</a>
                            </td>
                            <td>
                                <div class="table-action-buttons">
                                    <!-- <a class="view button button-box button-xs button-primary" data-toggle="modal"
                                        data-target="#modal" data-remote="{{route('products.show', $product->id)}}"
                                        href="#"><i class="zmdi zmdi-more"></i></a> -->
                                    <a class="edit button button-box button-xs button-info"
                                        href="{{route('products.edit', $product->id)}}" href="#"><i
                                            class="zmdi zmdi-edit"></i></a>
                                    <a wire:click="delete($product)" class="delete button button-box button-xs button-danger" href="#"><i
                                            class="zmdi zmdi-delete"></i></a
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--Manage Product List End-->

    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{$products->links()}}
        </div>
    </div>
