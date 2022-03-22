<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Product;
use App\Models\BundleProduct;
use Illuminate\Http\Request;
use App\Http\Resources\Bundle as BundleResource;
use App\Http\Resources\BundleCollection;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use Image;
use URL;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    	$data['bundles'] = Bundle::with('products')->get();

        return view('bundles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    	$data['products'] = Product::with('preacher')->active()->get();

        return view('bundles.create', $data);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show(Bundle $bundle)
    {
    	$data['bundle'] = Bundle::with('products')->where('id', $bundle->id)->first();

    	return view('bundles.show', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($slug)
    {
        $data['bundle'] = Bundle::with('products.preacher')->where('slug', $slug)->first();

        return view('bundles.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function edit(Bundle $bundle)
    {
    	$data['bundle'] = Bundle::find($bundle->id);

    	return view('bundles.edit', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $bundle = Bundle::find($id);

        if ($bundle) {
            $bundle->delete();
        }

        return redirect()->route('bundles.index');
    }

    public function searchBundles($searchString) {
        // dd($searchString);
        return Bundle::search($searchString)
                    ->with('products.preacher')
                    ->active()
                    ->paginate(20);
    }
}
