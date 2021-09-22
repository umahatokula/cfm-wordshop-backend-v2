<?php

namespace App\Models;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class Product extends Model implements Searchable
{
    use HasSlug;
    use SearchableTrait;
    use HasFactory;

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

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.sku' => 10,
        ],
        // 'joins' => [
        //     'categories' => ['products.id','categories.product_id'],
        //     'preacher' => ['products.id','preachers.product_id'],
        // ],
    ];

    protected $casts = [
        'is_taxable' => 'boolean',
        'is_fulfilled' => 'boolean',
        'is_available' => 'boolean',
        'is_discountable' => 'boolean',
        'is_active' => 'boolean',
        'is_digital' => 'boolean',
        'is_audio' => 'boolean',
    ];


    public function getSearchResult(): SearchResult
    {
       $url = route('products.show', $this->id);

       return new SearchResult($this, $this->name, $url);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * The categories that belong to the product.
     */
    public function preacher()
    {
        return $this->belongsTo('App\Models\Preacher');
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
     */
    public function getTempDownloadUrl() {
        $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        // secret: nW/SMC1lsYQyA/jlQt72rMGdx+/hWwC4Sq1/zICp
        // key: AKIATYSMHYAZ6FCHR522

        //Creating a presigned URL
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => 'cfm-media-audio',
            'Key' => $this->s3_key
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+2 days');

        // Get the actual presigned-url
        return (string)$request->getUri();
    }

    /**
    * Generate download link for free download
    */
    public function freeDownloadLink() {
        $s3Client = \Storage::disk('s3')->getDriver()->getAdapter()->getClient();

        //Creating a presigned URL
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => 'cfm-media-audio',
            'Key' => $this->s3_key
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+1 day');

        // Get the actual presigned-url
        return (string)$request->getUri();

    }
}
