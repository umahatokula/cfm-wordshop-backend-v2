<?php

namespace App\Http\Livewire\Products;

use Carbon\Carbon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Preacher;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\CategoryProduct;

class Create extends Component
{

    use WithFileUploads;

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

    public $product_file;

    public $preachers, $categories, $productCategories;

    protected $rules = [
        'name'              => 'required|string|min:6',
        'sku'               => 'required',
        'unit_price'        => 'required',
        // 'download_link'     => 'required',
        // 's3_key'            => 'required',
        'preacher_id'       => 'required',
        'date_preached'     => 'required',
        'product_file'     => 'required',
        'image'             => 'required|image|max:1024',
    ];

    /**
     * mount
     *
     * @param  mixed $product
     * @return void
     */
    public function mount() {

        $this->categories = Category::all();
        $this->preachers  = Preacher::all();
    }


    public function save() {
        // $this->validate();

        $product                       = new Product;
        $product->name                 = $this->name;
        $product->sku                  = $this->sku;
        $product->description          = $this->description;
        $product->unit_price           = $this->unit_price;
        $product->discount_price       = isset($this->discount_price) ?? null;
        $product->quantity_per_unit    = isset($this->quantity_per_unit) ? $this->quantity_per_unit : 0;
        $product->units_in_stock       = isset($this->units_in_stock) ? $this->units_in_stock : 0;
        $product->is_digital           = isset($this->is_digital) ? 1 : 0;
        $product->is_active            = isset($this->is_active) ? 1 : 0;
        $product->is_audio             = isset($this->is_audio) ? 1 : 0;
        $product->is_taxable           = isset($this->is_taxable) ? 1 : 0;
        $product->is_available         = isset($this->is_available) ? 1 : 0;
        $product->is_discountable      = isset($this->is_discountable) ? 1 : 0;
        $product->reorder_level        = $this->reorder_level;
        $product->download_link        = $this->download_link;
        $product->s3_key               = $this->s3_key;
        $product->preacher_id          = $this->preacher_id;
        $product->date_preached        = $this->date_preached;
//        $product->save();
//        dd($product);
        dd($this->product_file, $this->image);

        $datePreached = Carbon::parse($this->date_preached);
        $messageYear = $datePreached->format('Y');
        $messageMonth = $datePreached->format('m');
        $path = 'audio/'.$messageYear.'/'.$messageMonth.'/';
        dd($this->product_file, $this->image);

        $this->product_file->storeAs($path, 'avatar', 's3');

        foreach ($this->productCategories as $category_id) {
            $cp = new CategoryProduct;
            $cp->product_id = $product->id;
            $cp->category_id = $category_id;
            $cp->save();
        }

        $product->save();

        // prepare and upload product image
        $product
        ->addMedia($this->image->getRealPath())
        ->usingName($this->image->getClientOriginalName())
        ->toMediaCollection('album_art', 'public');

        redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.products.create');
    }
}
