<?php

namespace App\Http\Livewire\Bundles;

use Image;
use App\Models\Bundle;
use App\Models\Product;
use Livewire\Component;
use App\Models\BundleProduct;
use Livewire\WithFileUploads;
use URL;

class EditBundle extends Component
{
    use WithFileUploads;    
    
    public $search;
    protected $queryString = ['search'];
    
    public $name, $price, $description, $image, $is_active, $bundleProducts, $cover_image, $allProducts;
    public $products;
    public Bundle $bundle;

    public $rules = [
        'name'     => 'required',
        'price'    => 'required',
        'products' => 'required|array|min:1',
    ];

    public $messages = [
        'name.required' => 'Name is required',
        'price.required' => 'Price is required',
        'products.required' => 'Please add products to this bundle',
    ];
    
    /**
     * mount
     *
     * @return void
     */
    public function mount(Bundle $bundle) {

        $this->bundle = $bundle;
        $this->name = $bundle->name;
        $this->price = $bundle->price;
        $this->description = $bundle->description;
        $this->is_active = $bundle->is_active;

        $this->bundleProducts = $this->bundle->products->load('preacher')->toArray();

        $this->allProducts = Product::with('preacher')->active()->get();

    }
    
    /**
     * addBundleProduct
     *
     * @param  mixed $productId
     * @return void
     */
    public function addBundleProduct($productId) {

        $product = $this->allProducts->where('id', $productId)->first();

        // ensure product has not already been added
        $exists = collect($this->bundleProducts)->filter(function($item, $key) use ($product) {
            return $item['id'] == $product['id'];
        });

        if ($exists->isNotEmpty()) {
            return;
        }

        $this->bundleProducts[] = $product->toArray();
    }
    
    /**
     * removeBundleProduct
     *
     * @param  mixed $productId
     * @return void
     */
    public function removeBundleProduct($index) {
        array_splice($this->bundleProducts, $index, 1);
    }
    
    /**
     * save
     *
     * @return void
     */
    public function save() {

        // $this->validate();

        $this->bundle->name                 = $this->name;
        $this->bundle->description          = $this->description;
        $this->bundle->price                = $this->price;
        $this->bundle->is_active            = $this->is_active ? 1 : 0;
        $this->bundle->large_image_path     = '';
        $this->bundle->thumbnail_image_path = '';
    	$this->bundle->save();


        // detach existing bundle-product ties
        BundleProduct::where('bundle_id', $this->bundle->id)->delete();

        foreach ($this->bundleProducts as $product) {

            BundleProduct::create([
                'bundle_id'  => $this->bundle->id,
                'product_id' => $product['id'],
            ]);

        }

        // save bundle album art
        if ($this->cover_image) {
            
            $this->validate([
                'cover_image' => 'image|max:1024', // 1MB Max
            ]);
    
            $this->bundle->getMedia('bundle_album_art')->each(function($mediaPhoto) {
                $mediaPhoto->delete();
            });

            $this->bundle
            ->addMedia($this->cover_image->getRealPath())
            ->usingName($this->cover_image->getClientOriginalName())
            ->toMediaCollection('bundle_album_art', 'public');
        }

    	redirect()->route('bundles.index');
    }

    public function render()
    {
        if ($this->search) {

            $this->products = $this->allProducts->filter(function($product) {
                return (strpos(strtolower($product->name), strtolower($this->search)) !== false);
            })->toArray();

        } else {

            $this->products = [];

        }

        return view('livewire.bundles.edit-bundle', [
            'products' => $this->products,
        ]);
    }
}
