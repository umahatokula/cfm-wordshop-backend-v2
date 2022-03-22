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
    public function index() {

        $products = Product::with('categories', 'preacher', 'media')->orderBy('date_preached', 'desc')->active()->get()->map(function($product) {
            if ($product->unit_price == 0) {
                return $product->free_download_link = $product->freeDownloadLink();
            }

            return $product;
        });

        $pageSize = 20;
        
        return response()->json([
            'status' => true,
            'data' => CollectionHelper::paginate($products, $pageSize)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->orWhere('slug', $id)->with('categories', 'preacher')->first();

        return response()->json([
            'status' => true,
            'data' => $product
        ], 200);
    }
    
    /**
     * download
     *
     * @param  mixed $product_id
     * @return void
     */
    public function download($id_orSlug) {

        $product = Product::where('id', $id_orSlug)->orWhere('slug', $id_orSlug)->first();

        return response()->json([
            'status' => true,
            'data' => [
                'download_url' => $product ? (string) $product->getTempDownloadUrl() : null,
            ]
        ], 200);

    }
    
    /**
     * searchProducts
     *
     * @param  mixed $searchString
     * @return void
     */
    public function searchProducts($searchString) {

        $products = Product::search($searchString)
                    ->with('preacher')
                    ->orderBy('date_preached', 'desc')
                    ->paginate(20);
                    
        foreach ($products as $product) {
            if ($product->unit_price == 0) {
                $product->free_download_link = $product->freeDownloadLink();
            }
        }

        return response()->json([
            'status' => true,
            'data' => $products
        ], 200);
    }
    
    /**
     * increment product count
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

            return response()->json([
                'status' => true,
                'data' => $product
            ], 200);
        }
    }
    
    /**
     * decrement product count
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

            return response()->json([
                'status' => true,
                'data' => $product
            ], 200);
        }
    }

}
