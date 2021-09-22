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
            'success' => true,
            'data' => $bundles
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['bundlesMenu'] = 1;
        $data['title'] = 'Create Bundles';
        
        return response([
            'products' => Product::with('preacher')->active()->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

    	$rules = [
    	'name'     => 'required',
    	'price'    => 'required',
    	'products' => 'required|array|min:1',
    	];

    	$messages = [
    	'name.required' => 'Name is required',
    	'price.required' => 'Price is required',
    	'products.required' => 'Please add products to this bundle',
    	];

        $this->validate($request, $rules, $messages);

        if ($request->image) {
            // prepare and upload product image
            $image = $request->file('image');
            $img = Image::make($image->getRealPath());
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        
            $destinationPath = 'bundle-images/';

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
        }

        $bundle                       = new Bundle;
        $bundle->name                 = $request->name;
        $bundle->description          = $request->description;
        $bundle->price                = $request->price;
        $bundle->is_active            = $request->is_active ? 1 : 0;
        $bundle->large_image_path     = isset($destinationPath) ? URL::to('/').'/'.$destinationPath.$originalImg->basename : '';
        $bundle->thumbnail_image_path = isset($destinationPath) ? URL::to('/').'/'.$destinationPath.'thumbnail/'.$thumbnail->basename : '';
    	$bundle->save();

        foreach ($request->products as $product) {
            // dd($product);
            BundleProduct::create([
                'bundle_id'  => $bundle->id,
                'product_id' => $product['id'],
            ]);
        }
        
        return response([
            'bundles' => $bundle->load('products')
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show(Bundle $bundle)
    {
    	$data['title'] = 'Edit Bundles';
    	$data['bundlesMenu'] = 1;

        if (request()->expectsJson()) {
            return response([
                'data' => new BundleResource(Bundle::find($bundle->id))
            ], 200);
        }

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
        $data['title'] = 'Edit Bundles';
        $data['bundlesMenu'] = 1;

        if (request()->expectsJson()) {
            return response([
                'data' => Bundle::with('products.preacher')->where('slug', $slug)->first()
            ], 200);
        }

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
    	$data['title'] = 'Edit Bundles';
    	$data['bundlesMenu'] = 1;
    	$data['bundle'] = Bundle::find($bundle->id);

    	return view('bundles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bundle $bundle)
    {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	];

    	$messages = [
    	'name.required' => 'Name is required',
    	];

        $this->validate($request, $rules, $messages);

        $bundle                 = Bundle::find($bundle->id);
        $bundle->name 		    = $request->name;
    	$bundle->description    = $request->description;
    	$bundle->price   	    = $request->price;
    	$bundle->is_active      = $request->is_active ? 1 : 0;
    	$bundle->save();

    	return redirect('bundles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundle $bundle)
    {
        //
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
