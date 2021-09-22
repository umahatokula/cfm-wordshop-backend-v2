<?php

namespace App\Http\Controllers\Api;

use URL;
use Image;
use Aws\S3\S3Client;
use App\Models\Bundle;
use App\Models\Product;
use App\Models\Category;
use App\Models\Preacher;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Models\CategoryProduct;
use Aws\Exception\AwsException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BundleCollection;
use App\Helpers\General\CollectionHelper;
use App\Http\Resources\ProductCollection;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_slug = null) {

        $products = Product::with('categories', 'preacher')->orderBy('date_preached', 'desc')->active()->get()->map(function($product) {
            if ($product->unit_price == 0) {
                return $product->free_download_link = $product->freeDownloadLink();
            }

            return $product;
        });

        $pageSize = 20;
        
        return $paginated = CollectionHelper::paginate($products, $pageSize);
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

        return response([
            'data' => new ProductResource($product)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($slug)
    {
        $product = Product::where('slug', $slug)->with('categories')->with('preacher')->first();
        if ($product->unit_price == 0) {
            $product->free_download_link = $product->freeDownloadLink();
        }

        return response([
            'data' => $product
        ], 200);
    }

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
