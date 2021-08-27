<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class Edit extends Component
{
    public Product $product;

    public $preachers;

    public $categories;
 
    protected $rules = [
        'product.name'       => 'required|string|min:6',
        'product.sku'                => 'required',
        'product.unit_price' => 'required',
        'product.description'        => 'required',
        'product.discount_price'     => 'required',
        'product.quantity_per_unit'  => 'required',
        'product.units_in_stock'     => 'required',
        'product.is_digital'         => 'required',
        'product.is_active'          => 'required',
        'product.is_audio'           => 'required',
        'product.is_taxable'         => 'required',
        'product.is_available'       => 'required',
        'product.is_discountable'    => 'required',
        'product.reorder_level'      => 'required',
        'product.download_link'      => 'required',
        'product.s3_key'             => 'required',
        'product.preacher_id'        => 'required',
        'product.date_preached'      => 'required',
    ];
 
    public function save() {
        $this->validate();
 
        $this->product->save();
    }

    public function render()
    {
        return view('livewire.products.edit', [
          'product' => $this->product
        ]);
    }
}
