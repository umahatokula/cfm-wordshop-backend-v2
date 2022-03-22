
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form wire:submit.prevent="save" class="">

                            <!-- Name Field -->
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10">
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <input wire:model.lazy="name" class="form-control" id="name" />
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Price Field -->
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10">
                                        <label for="price">Price</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <input wire:model.lazy="price" class="form-control" id="price" />
                                        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10">
                                        <label for="description">Description</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <textarea wire:model.lazy="description" class="form-control" id="description"> </textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="col-12 mb-20">
                                <div class="adomx-checkbox-radio-group inline">

                                    <label class="adomx-switch"> <span class="text">Activate/Deactivate </span> &nbsp
                                    <input wire:model.lazy="is_active"  value="false" type="checkbox" class="toggle-switch"> <i class="lever"></i></label>

                                </div>
                            </div>

                            <!-- Description Field -->
                            <div class="col-12 mb-20">
                                <div class="row mbn-10">
                                    <div class="col-sm-3 col-12 mb-10">
                                        <label for="cover_image">Cover Image</label>
                                    </div>
                                    <div class="col-sm-9 col-12 mb-10">
                                        <input wire:model.lazy="cover_image" class="form-control" id="cover_image" type="file"> </input>
                                        @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Field -->
                            <div class="form-group col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Products in Bundle</h4>
                        <div class="list-group">
                            @forelse ($bundleProducts as $index => $bundleProduct)
                                <a wire:click="removeBundleProduct({{ $index }})" class="list-group-item list-group-item-action">{{ $bundleProduct['name'] }} | <span class="text-danger">{{ isset($bundleProduct['preacher']) ? $bundleProduct['preacher']['name'] : null }}</span></a>
                            @empty
                                No products
                            @endforelse                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Products</h4>
                        <p><input wire:model.lazy="search" type="search" placeholder="Filter Products" class="form-control" /></p>
                        <div class="list-group">
                           @forelse ($products as $product)
                           <a wire:click="addBundleProduct({{ $product['id'] }})" class="list-group-item list-group-item-action">{{ $product['name'] }} | <span class="text-info">{{ isset($product['preacher']) ? $product['preacher']['name'] : null }}</span></a>
                           @empty
                               No products
                           @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>