<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Preacher;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\CategoryProduct;

class Edit extends Component
{
    
    use WithFileUploads;

    public Product $product;
    public $name,
        $sku,
        $unit_price,
        $description,
        $discount_price,
        $quantity_per_unit,
        $units_in_stock,
        $is_digital,
        $is_active,
        $is_audio,
        $is_taxable,
        $is_available,
        $is_discountable,
        $reorder_level,
        $download_link,
        $s3_key,
        $preacher_id,
        $date_preached,
        $image;

    public $preachers, $categories, $productCategories;
 
    protected $rules = [
        'name'              => 'required|string|min:6',
        'sku'               => 'required',
        'unit_price'        => 'required',
        'download_link'     => 'required',
        's3_key'            => 'required',
        'preacher_id'       => 'required',
        'date_preached'     => 'required',
        // 'image'             => 'image|max:1024',
    ];
    
    /**
     * mount
     *
     * @param  mixed $product
     * @return void
     */
    public function mount(Product $product) {

        $this->product = $product;
        $this->productCategories = $product->categories->map(function($category) {
            return $category->id;
        })->toArray();
        $this->categories = Category::all();
        $this->preachers  = Preacher::all();

        $this->name              = $product->name;
        $this->sku               = $product->sku;
        $this->unit_price        = $product->unit_price;
        $this->description       = $product->description;
        $this->discount_price    = $product->discount_price;
        $this->quantity_per_unit = $product->quantity_per_unit;
        $this->units_in_stock    = $product->units_in_stock;
        $this->is_digital        = $product->is_digital;
        $this->is_active         = $product->is_active;
        $this->is_audio          = $product->is_audio;
        $this->is_taxable        = $product->is_taxable;
        $this->is_available      = $product->is_available;
        $this->is_discountable   = $product->is_discountable;
        $this->reorder_level     = $product->reorder_level;
        $this->download_link     = $product->download_link;
        $this->s3_key            = $product->s3_key;
        $this->preacher_id       = $product->preacher_id;
        $this->date_preached     = $product->date_preached;
        $this->image             = $product->image;
    }
    
 
    public function save() {

        $this->validate();

        $this->product->name                 = $this->name;
        $this->product->sku                  = $this->sku;
        $this->product->description          = $this->description;
        $this->product->unit_price           = $this->unit_price;
        $this->product->discount_price       = isset($this->discount_price) ? 1 : 0;
        $this->product->quantity_per_unit    = isset($this->quantity_per_unit) ? $this->quantity_per_unit : 0;
        $this->product->units_in_stock       = isset($this->units_in_stock) ? $this->units_in_stock : 0;
        $this->product->is_digital           = isset($this->is_digital) ? 1 : 0;
        $this->product->is_active            = isset($this->is_active) ? 1 : 0;
        $this->product->is_audio             = isset($this->is_audio) ? 1 : 0;
        $this->product->is_taxable           = isset($this->is_taxable) ? 1 : 0;
        $this->product->is_available         = isset($this->is_available) ? 1 : 0;
        $this->product->is_discountable      = isset($this->is_discountable) ? 1 : 0;
        $this->product->reorder_level        = $this->reorder_level;
        $this->product->download_link        = $this->download_link;
        $this->product->s3_key               = $this->s3_key;
        $this->product->preacher_id          = $this->preacher_id;
        $this->product->date_preached        = $this->date_preached;

        // $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        // $s3ObjectHeader = $s3Client->headObject([
        //     'Bucket' => env('AWS_BUCKET', 'cfm-media-audio'),
        //     'Key' => $this->product->s3_key
        // ]);

        // $this->product->file_size = round($s3ObjectHeader['ContentLength'] / 1024 / 1024, 2);
        // $this->product->save();

        CategoryProduct::where('product_id', $this->product->id)->delete();

        foreach ($this->productCategories as $category_id) {
            $cp = new CategoryProduct;
            $cp->product_id = $this->product->id;
            $cp->category_id = $category_id;
            $cp->save();
        }
 
        $this->product->save();

        // prepare and upload product image
        if ($this->image) {

            $this->product->getMedia('album_art')->each(function($mediaPhoto) {
                $mediaPhoto->delete();
            });

            $this->product
            ->addMedia($this->image->getRealPath())
            ->usingName($this->image->getClientOriginalName())
            ->toMediaCollection('album_art', 'public');
        }
        

        redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.products.edit', [
          'product' => $this->product
        ]);
    }
}
