<?php

namespace App\Http\Controllers;

use App\Helpers\General\CollectionHelper;
use App\Http\Requests\Products\CreateProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\Category;
use App\Models\Preacher;
use App\Models\Bundle;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\BundleCollection;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Support\Arr;
use Spatie\Searchable\Search;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Image;
use URL;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_slug = null) {
        $data['productsMenu'] = 1;
        $data['title'] = 'Manage Products';
//        dd(Product::orderBy('created_at', 'desc')->first()->album_art);

        $data['products'] = Product::with('categories', 'preacher')->orderBy('date_preached', 'desc')->paginate(20);

        return view('products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::all();
        $data['preachers'] = Preacher::all();

        return view('products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProduct $request) {
//        dd($request->all());

        $product                       = new Product;
        $product->name                 = $request->name;
        $product->sku                  = $request->sku;
        $product->description          = $request->description;
        $product->unit_price           = $request->unit_price;
        $product->discount_price       = $request->discount_price;
        $product->quantity_per_unit    = $request->has('quantity_per_unit') ? $request->quantity_per_unit : 0;
        $product->units_in_stock       = $request->has('units_in_stock') ? $request->units_in_stock : 0;
        $product->is_digital           = $request->has('is_digital') ? 1 : 0;
        $product->is_active            = $request->has('is_active') ? 1 : 0;
        $product->is_audio             = $request->has('is_audio') ? 1 : 0;
        $product->is_taxable           = $request->has('is_taxable') ? 1 : 0;
        $product->is_available         = $request->has('is_available') ? 1 : 0;
        $product->is_discountable      = $request->has('is_discountable') ? 1 : 0;
        $product->reorder_level        = $request->reorder_level;
        $product->download_link        = $request->download_link ? $request->download_link : $download_link;
        $product->s3_key               = $request->s3_key;
        $product->preacher_id          = $request->preacher_id;
        $product->date_preached        = $request->date_preached;
        $product->size                 = null;
        $product->format               = null;
        $product->large_image_path     = null;
        $product->thumbnail_image_path = null;
        $product->save();

        // store thumbnail
//        $product->addMediaFromRequest('image')->toMediaCollection('thumbnail');

        $date_preached = Carbon::parse($request->date_preached);
        $album_art_path = 'albumarts/'.$date_preached->year.'/'.$date_preached->month;
        $s3_album_art = Storage::disk('s3')->put($album_art_path, $request->image, 'public');
        $product->s3_album_art     = $s3_album_art;
        $product->save();

        foreach ($request->categories as $category_id) {
            $cp = new CategoryProduct;
            $cp->product_id = $product->id;
            $cp->category_id = $category_id;
            $cp->save();
        }

        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->with('categories')->first();

        return view('products.show', compact('product'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($slug) {

        $product = Product::where('slug', $slug)->with('categories')->with('preacher')->first();

        if ($product->unit_price == 0) {
            $product->free_download_link = $product->freeDownloadLink();
        }

        $data['product'] = $product;

        return view('products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data['product']    = Product::where('id', $id)->with('categories')->first();
        $data['categories'] = Category::all();
        $data['preachers'] = Preacher::all();

        return view('products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
//        dd($request->all());

        $rules = [
            'name' => 'required',
            'unit_price' => 'required',
            'categories' => 'required',
            // 'download_link' => 'required_if:is_digital,on',
            's3_key' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'name.required' => 'Product Name is required',
            'download_link.required_if' => 'If a product is digital, then a download link is required',
            'image.required' => 'Please upload an album art',
        ];

        $this->validate($request, $rules, $messages);

        $product                       = Product::find($id);
        $product->name                 = $request->name;
        $product->sku                  = $request->sku;
        $product->description          = $request->description;
        $product->unit_price           = $request->unit_price;
        $product->discount_price       = $request->discount_price;
        $product->quantity_per_unit    = $request->has('quantity_per_unit') ? $request->quantity_per_unit : 0;
        $product->units_in_stock       = $request->has('units_in_stock') ? $request->units_in_stock : 0;
        $product->is_digital           = $request->has('is_digital') ? 1 : 0;
        $product->is_active            = $request->has('is_active') ? 1 : 0;
        $product->is_audio             = $request->has('is_audio') ? 1 : 0;
        $product->is_taxable           = $request->has('is_taxable') ? 1 : 0;
        $product->is_available         = $request->has('is_available') ? 1 : 0;
        $product->is_discountable      = $request->has('is_discountable') ? 1 : 0;
        $product->reorder_level        = $request->reorder_level;
        $product->download_link        = $request->download_link ? $request->download_link : $download_link;
        $product->s3_key               = $request->s3_key;
        $product->preacher_id          = $request->preacher_id;
        $product->date_preached        = $request->date_preached;
        $product->size                 = null;
        $product->format               = null;
        $product->large_image_path     = null;
        $product->thumbnail_image_path = null;
        $product->save();

        if ($request->image) {

            $date_preached = Carbon::parse($request->date_preached);
            $album_art_path = 'albumarts/'.$date_preached->year.'/'.$date_preached->month;
            $s3_album_art = Storage::disk('s3')->put($album_art_path, $request->image, 'public');
            $product->s3_album_art     = $s3_album_art;
            $product->save();

        }

        foreach ($request->categories as $category_id) {
            $cp = new CategoryProduct;
            $cp->product_id = $product->id;
            $cp->category_id = $category_id;
            $cp->save();
        }

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Download digital product
     *
     * @param  mixed $product_id
     * @return void
     */
    public function download($product_id) {

        $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        //Creating a presigned URL
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => 'audio/2020/JULY/200726-New Beginnings.mp3'
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+2 days');

        // Get the actual presigned-url
        return (string)$request->getUri();

    }

    /**
     * Search products
     *
     * @param  mixed $searchString
     * @return void
     */
    public function searchProducts($searchString) {
        // dd($searchString);
        $products = Product::search($searchString)
            ->with('preacher')
            ->orderBy('date_preached', 'desc')
            ->paginate(20);

        foreach ($products as $product) {
            if ($product->unit_price == 0) {
                $product->free_download_link = $product->freeDownloadLink();
            }
        }

        return $products;
    }

    /**
     * Increment units in stock
     *
     * @param  mixed $product_id
     * @return void
     */
    public function increment($product_id) {
        $product = Product::find($product_id);

        if ($product) {

            if (!$product->is_digital) {
                $product->increment('units_in_stock');
            } else {
                $product->units_in_stock = 0;
                $product->save();
            }

            return $product;
        }
    }

    /**
     * Decrement units in stock
     *
     * @param  mixed $product_id
     * @return void
     */
    public function decrement($product_id) {
        $product = Product::find($product_id);

        if ($product) {

            if (!$product->is_digital) {
                $product->decrement('units_in_stock');
            } else {
                $product->units_in_stock = 0;
                $product->save();
            }

            return $product;
        }
    }


}
