<?php

namespace App\Http\Controllers\Api;

use URL;
use Image;
use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\BundleProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\BundleCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\Bundle as BundleResource;
use App\Http\Resources\Product as ProductResource;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bundles = Bundle::with('products.preacher')->orderBy('created_at', 'desc')->active()->get();

        return  response([
            'status' => true,
            'data' => $bundles
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response([
            'status' => true,
            'data' => new BundleResource(Bundle::where('id', $id)->orWhere('slug', $id)->first())
        ], 200);
    }
    
    /**
     * searchBundles
     *
     * @param  mixed $searchString
     * @return void
     */
    public function searchBundles($searchString) {

        $bundle =  Bundle::search($searchString)
                    ->with('products.preacher')
                    ->active()
                    ->paginate(20);

        return response()->json([
            'status' => true,
            'data' => $bundle
        ], 200);
    }
}
