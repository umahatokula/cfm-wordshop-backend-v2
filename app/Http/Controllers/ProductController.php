<?php

namespace App\Http\Controllers;

use App\Helpers\General\CollectionHelper;
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

        $data['products'] = Product::with('categories', 'preacher')->orderBy('date_preached', 'desc')->paginate(20);

        return view('products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::pluck('name', 'id');
        $data['preachers'] = Preacher::pluck('name', 'id');

        return view('products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // dd($request->all());

        $rules = [
        'name' => 'required',
        'sku' => 'required',
        'unit_price' => 'required',
        'categories' => 'required',
        'download_link' => 'required_if:is_digital,on',
        's3_key' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
        'name.required' => 'Product Name is required',
        'download_link.required_if' => 'If a product is digital, then a download link is required',
        'image.required' => 'Please upload an album art',
        ];

        $this->validate($request, $rules, $messages);

        // prepare and upload product image
        $image = $request->file('image');
        $img = Image::make($image->getRealPath());
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = 'products-images/';

        $originalImageDestinationPath = public_path($destinationPath);
        $originalImg = $img->save($originalImageDestinationPath.'/'.$input['imagename']);


        $thumbnailDestinationPath = public_path($destinationPath.'thumbnail');

        // $thumbnail = $img->resize(300, 200, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save($thumbnailDestinationPath.'/'.$input['imagename']);

        $thumbnail = $img
                    ->resize(250, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->text('WordShop', 20, 0, function($font) {
                        // $font->file('foo/bar.ttf');
                        $font->size(24);
                        $font->color('#fdf6e3');
                        $font->align('center');
                        $font->valign('top');
                        $font->angle(45);
                    })
                    ->save($thumbnailDestinationPath.'/'.$input['imagename']);

        // upload downloadable file
        $download_link = '';
        if ($request->hasFile('downloadable_file')) {
            $downloadableFile = $request->file('downloadable_file');
            $downloadableFileName = time() . '.' . $downloadableFile->getClientOriginalExtension();
            $s3 = \Storage::disk('s3');
            $filePath = date('Y') .'/'. date('m') .'/'. $downloadableFileName;
            $s3->put($filePath, file_get_contents($downloadableFile), 'public');
            $download_link = env('AWS_URL').$filePath;
        }

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
        $product->size                 = $image->getSize();
        $product->format               = $image->getMimeType();
        $product->large_image_path     = URL::to('/').'/'.$destinationPath.$originalImg->basename;
        $product->thumbnail_image_path = URL::to('/').'/'.$destinationPath.'thumbnail/'.$thumbnail->basename;

        $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        $s3ObjectHeader = $s3Client->headObject([
            'Bucket' => env('AWS_BUCKET', 'cfm-media-audio'),
            'Key' => $product->s3_key
        ]);

        $product->file_size = round($s3ObjectHeader['ContentLength'] / 1024 / 1024, 2);
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
        // dd($request->all());

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
        
        if ($request->hasFile('image')) {

            // prepare and upload product image
            $image = $request->file('image');
            $img = Image::make($image->getRealPath());
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = 'products-images/';

            $originalImageDestinationPath = public_path($destinationPath);
            $originalImg = $img->save($originalImageDestinationPath.'/'.$input['imagename']);


            $thumbnailDestinationPath = public_path($destinationPath.'thumbnail');

            $thumbnail = $img
                        ->resize(250, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->text('WordShop', 20, 0, function($font) {
                            // $font->file('foo/bar.ttf');
                            $font->size(24);
                            $font->color('#fdf6e3');
                            $font->align('center');
                            $font->valign('top');
                            $font->angle(45);
                        })
                        ->save($thumbnailDestinationPath.'/'.$input['imagename']);

            // upload downloadable file
            $download_link = '';
            if ($request->hasFile('downloadable_file')) {
                $downloadableFile = $request->file('downloadable_file');
                $downloadableFileName = time() . '.' . $downloadableFile->getClientOriginalExtension();
                $s3 = \Storage::disk('s3');
                $filePath = date('Y') .'/'. date('m') .'/'. $downloadableFileName;
                $s3->put($filePath, file_get_contents($downloadableFile), 'public');
                $download_link = env('AWS_URL').$filePath;
            }

            // update product properties
            $product->size                 = $image->getSize();
            $product->format               = $image->getMimeType();
            $product->large_image_path     = URL::to('/').'/'.$destinationPath.$originalImg->basename;
            $product->thumbnail_image_path = URL::to('/').'/'.$destinationPath.'thumbnail/'.$thumbnail->basename;
        }

        // $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();
        //
        // $s3ObjectHeader = $s3Client->headObject([
        //     'Bucket' => env('AWS_BUCKET', 'cfm-media-audio'),
        //     'Key' => $product->s3_key
        // ]);
        //
        // $product->file_size = round($s3ObjectHeader['ContentLength'] / 1024 / 1024, 2);
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
