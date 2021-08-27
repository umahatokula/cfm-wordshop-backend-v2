<div class="row">
    <div class="col-xlg-12 col-md-12 col-12 mb-30">
        <div class="">
            <table class="table">
                <tbody>
                    <tr>
                        <td scope="row">SKU</td>
                        <td>{{$product->sku}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Name</td>
                        <td>{{$product->name}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Description</td>
                        <td>{{$product->description}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Unit Price</td>
                        <td>{{number_format($product->unit_price, 2)}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Discount Price</td>
                        <td>{{number_format($product->discount_price, 2)}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Qty per unit</td>
                        <td>{{$product->quantity_per_unit}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Unit in stock</td>
                        <td>{{$product->units_in_stock}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Units on order</td>
                        <td>{{$product->units_on_order}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Reorder Level</td>
                        <td>{{$product->reorder_level}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Is Taxable</td>
                        <td>{{$product->is_taxable?'Yes':'No'}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Is Available</td>
                        <td>{{$product->is_available?'Yes':'No'}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Is Discountable</td>
                        <td>{{$product->is_discountable?'Yes':'No'}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Is Active</td>
                        <td>{{$product->is_active?'Yes':'No'}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Is Digital</td>
                        <td>{{$product->is_digital?'Yes':'No'}}</td>
                    </tr>
                    <tr>
                        <td scope="row">Download Link</td>
                        <td>
                            <a href="{{$product->download_link}}">{{$product->download_link}}</a>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row">Image</td>
                        <td>
                            <img src="{{$product->thumbnail_image_path}}" class="img-fluid" alt="{{$product->sku}}">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

