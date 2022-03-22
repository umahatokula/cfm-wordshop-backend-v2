<?php

namespace App\Models;

use App\Models\OrderDetail;
use Spatie\Sluggable\HasSlug;
use Spatie\Searchable\Searchable;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Nicolaslopezj\Searchable\SearchableTrait;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements Searchable, HasMedia
{
    use HasSlug;
    use SearchableTrait;
    use HasFactory;
    use InteractsWithMedia;

    protected $hidden = [
        'download_link',
        's3_key',
        'created_at',
        'deleted_at',
        'quantity_per_unit',
        'reorder_level',
        'units_in_stock',
        'units_on_order',
        'updated_at'
    ];

    protected $dates = ['date_preached'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected $casts = [
        'is_taxable' => 'boolean',
        'is_fulfilled' => 'boolean',
        'is_available' => 'boolean',
        'is_discountable' => 'boolean',
        'is_active' => 'boolean',
        'is_digital' => 'boolean',
        'is_audio' => 'boolean',
    ];

    protected $appends = ['no_of_downloads', 'album_art'];

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')
              ->width(150)
              ->height(150)
              ->sharpen(10);
    }
    
    /**
     * getLargeImagePathAttribute
     *
     * @return void
     */
    public function getAlbumArtAttribute() {
        return $this->getFirstMedia('album_art') ? $this->getFirstMedia('album_art')->getUrl() : $this->large_image_path;
    }

    
    /**
     * getSearchResult
     *
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult {
       $url = route('products.show', $this->id);

       return new SearchResult($this, $this->name, $url);
    }
    
    /**
     * scopeActive
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeActive($query) {
        return $query->where('is_active', 1);
    }
    
    /**
     * Get number of downloads for product
     *
     * @return void
     */
    public function getNoOfDownloadsAttribute() {

        return OrderDetail::where('product_id', $this->id)->whereHas('order', function($query) {
            return $query->where('is_fulfilled', 1);
        })->get()->count();
        
    }

    /**
     * The categories that belong to the product.
     */
    public function preacher()
    {
        return $this->belongsTo('App\Models\Preacher')->withDefault();
    }

    /**
     * 
     */
    public function order_details()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

    /**
     * The categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_product');
    }

    /**
     * Trim S3 Key.
     *
     * @param  string  $value
     * @return string
     */
    public function getS3KeyAttribute($value)
    {
        return trim($value);
    }

    /**
     * Product temporary link
     */
    public function link() {
        return $this->hasOne('App\Models\TempDownloadLink');
    }

        
    /**
     * Generate pre-signed amazon s3 download link
     *
     * @param  mixed $timeToExpiration in days. Default is 2 days
     * @return string
     */
    public function getTempDownloadUrl($timeToExpiration = 2) : string {
        $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        //Creating a presigned URL
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $this->s3_key
        ]);

        $response = $s3Client->createPresignedRequest($cmd, '+'.$timeToExpiration.' days');

        // Get the actual presigned-url
        return (string) $response->getUri();
    }

        
        
    /**
     * Generate download link for free download
     *
     * @return string
     */
    public function freeDownloadLink() : string {
        $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        //Creating a presigned URL
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => 'cfm-media-audio',
            'Key' => $this->s3_key
        ]);

        $response = $s3Client->createPresignedRequest($cmd, '+1 day');

        // Get the actual presigned-url
        return (string) $response->getUri();

    }
}
