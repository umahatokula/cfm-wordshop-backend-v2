<div>
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
                    <form wire:submit.prevent="save">
                          <div class="row mbn-20">

                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="is_active">  Active/Inactive</label>
                                      </div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <div class="adomx-checkbox-radio-group">
                                              <label class="adomx-checkbox-2">
                                                <input wire:model="is_active" id="is_active" type="checkbox"> <i class="icon"></i> Active/Inactive</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="name">Name</label>
                                      </div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="name" class='form-control' id="name" placeholder='Name' />
                                      </div>
                                  </div>
                              </div>

                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="sku">SKU</label>
                                      </div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="sku" class='form-control' id="sku" placeholder='Sku' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="description"> Description</label>
                                      </div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="description" class='form-control' id="description" type="text" placeholder='Description' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="unit_price"> Unit Price</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="unit_price" class='form-control' id="unit_price" type="text" placeholder='Unit Price' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20 download_linkDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="download_link"> Download Link</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="download_link" class='form-control' id="download_link" type="text" placeholder='Download Link' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20 download_linkDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="s3_key"> Object Key</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="s3_key" class='form-control' id="s3_key" type="text" placeholder='Object Key' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20" id="preacher_idDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="preacher_id"> Preacher</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <select wire:model.defer="preacher_id" class="form-control" id="preacher_id">
                                            @foreach ($preachers as $preacher)
                                                <option value="{{ $preacher->id }}">{{ $preacher->name }}</option>
                                            @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20" id="date_preachedDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="preacher_id"> Date Preached</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="date_preached" class='form-control' id="date_preached" type="date" />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="productCategories"> Categories</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <select wire:model.defer="productCategories" class="form-control" id="productCategories" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="image"> Product Image</label>
                                      </div>
                                      <div class="col-sm-9 col-12 mb-10">
                                        <input wire:model.defer="image" class="" type="file" data-height="220">
                                      </div>
                                  </div>
                              </div>

                              <div class="col-12 mb-20">
                                  <input type="submit" value="Cancel" class="button button-danger">
                                  <input type="submit" value="Submit" class="button button-primary">
                              </div>

                          </div>
                      {!! Form::close() !!}
                  </div>

              </div><!-- Add or Edit Product End -->
          </div>
      </div>
  </div>
</div>
