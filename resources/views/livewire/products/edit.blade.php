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
                                                <input wire:model="product.is_active" {{ $product->is_active ? 'checked' : null }} id="is_active" type="checkbox"> <i class="icon"></i> Active/Inactive</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="name">Name</label>
                                      </div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.name" class='form-control' id="name" placeholder='Name' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="description"> Description</label>
                                      </div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.description" class='form-control' id="description" type="text" placeholder='Description' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="unit_price"> Unit Price</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.unit_price" class='form-control' id="unit_price" type="text" placeholder='Unit Price' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="discount_price"> Discount
                                              Price</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.discount_price" class='form-control' id="discount_price" type="text" placeholder='Discount Price' />
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
                                                  <input wire:model.defer="product.is_digital" {{ $product->is_digital ? 'checked' : null }} id="is_digital" type="checkbox"> <i class="icon"></i> Is Digital</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20 download_linkDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="download_link"> Download Link</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.download_link" class='form-control' id="download_link" type="text" placeholder='Download Link' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20 download_linkDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="s3_key"> Object Key</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.s3_key" class='form-control' id="s3_key" type="text" placeholder='Object Key' />
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
                                                  <input wire:model="product.is_audio" {{ $product->is_audio ? 'checked' : null }} id="is_audio" type="checkbox"> <i class="icon"></i> Audio?</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20" id="quantity_per_unitDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="quantity_per_unit"> Quantity per
                                              Unit</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.quantity_per_unit" class='form-control' id="quantity_per_unit" type="text" placeholder='Quantity per Unit' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20" id="units_in_stockDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="units_in_stock"> Units in
                                              stock</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.units_in_stock" class='form-control' id="units_in_stock" type="text" placeholder='Units in stock' />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20" id="reorder_levelDiv">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="reorder_level"> Re-order Level</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <input wire:model.defer="product.reorder_level" class='form-control' id="reorder_level" type="text" placeholder='Re-order Level' />
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
                                          <input wire:model.defer="product.date_preached" class='form-control' id="date_preached" type="date" />
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 mb-20">
                                  <div class="row mbn-10">
                                      <div class="col-sm-3 col-12 mb-10"><label for="categories"> Categories</label></div>
                                      <div class="col-sm-9 col-12 mb-10">
                                          <select wire:model.defer="product.categories[]" class="form-control" id="categories" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category }}">{{ $category }}</option>
                                            @endforeach
                                          </select>
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
                                                  <input wire:model.defer="product.is_taxable" name="is_taxable" id="is_taxable" type="checkbox"> <i
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
                                                  <input wire:model.defer="product.is_discountable" name="is_discountable" id="is_discountable" type="checkbox"> <i
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
</div>
