<?php

namespace App\Http\Livewire\Bundles;

use Image;
use App\Models\Bundle;
use App\Models\Product;
use Livewire\Component;
use App\Models\BundleProduct;
use Livewire\WithFileUploads;
use URL;

class CreateBundle extends Component
{
    use WithFileUploads;    
    
    public $search;
    protected $queryString = ['search'];
    
    public $name, $price, $description, $image, $is_active, $bundleProducts, $cover_image, $allProducts;
    public $products;

    public $rules = [
        'name'     => 'required',
        'price'    => 'required',
        'products' => 'required|array|min:1',
        'cover_image' => 'required|image|max:1024', // 1MB Max
    ];

    public $messages = [
        'name.required' => 'Name is required',
        'price.required' => 'Price is required',
        'products.required' => 'Please add products to this bundle',
        'cover_image.required' => 'Please add an album art to this bundle', // 1MB Max
    ];
    
    /**
     * mount
     *
     * @return void
     */
    public function mount() {
        $this->allProducts = Product::with('preacher')->active()->get();
        $this->bundleProducts = [];
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

        $this->validate();

        $bundle                       = new Bundle;
        $bundle->name                 = $this->name;
        $bundle->description          = $this->description;
        $bundle->price                = $this->price;
        $bundle->is_active            = $this->is_active ? 1 : 0;
        $bundle->large_image_path     = isset($image_path) ? URL::to('/').'/'.$image_path : '';
        $bundle->thumbnail_image_path = '';
    	$bundle->save();

        foreach ($this->bundleProducts as $product) {

            BundleProduct::create([
                'bundle_id'  => $bundle->id,
                'product_id' => $product['id'],
            ]);

        }

        // save bundle album art
        if ($this->cover_image) {

            $bundle->getMedia('bundle_album_art')->each(function($mediaPhoto) {
                $mediaPhoto->delete();
            });

            $bundle
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

        return view('livewire.bundles.create-bundle', [
            'products' => $this->products,
        ]);
    }
}
