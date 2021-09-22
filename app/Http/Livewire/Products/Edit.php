<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;

class Edit extends Component
{
    
    use WithFileUploads;

    public Product $product;

    public $preachers;

    public $categories;
 
    protected $rules = [
        'product.name'       => 'required|string|min:6',
        'product.sku'                => 'required',
        'product.unit_price' => 'required',
        'product.description'        => 'required',
        'product.discount_price'     => 'required',
        'product.quantity_per_unit'  => 'required',
        'product.units_in_stock'     => 'required',
        'product.is_digital'         => 'required',
        'product.is_active'          => 'required',
        'product.is_audio'           => 'required',
        'product.is_taxable'         => 'required',
        'product.is_available'       => 'required',
        'product.is_discountable'    => 'required',
        'product.reorder_level'      => 'required',
        'product.download_link'      => 'required',
        'product.s3_key'             => 'required',
        'product.preacher_id'        => 'required',
        'product.date_preached'      => 'required',
        'product.image'              => 'image|max:1024',
    ];
    
 
    public function save(Request $request) {
        dd($request->unit_price);

        $this->validate();

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
 
        $this->product->save();
    }

    public function render()
    {
        return view('livewire.products.edit', [
          'product' => $this->product
        ]);
    }
}
