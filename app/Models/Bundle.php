<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class Bundle extends Model implements Searchable, HasMedia
{
    use SearchableTrait;
    use HasSlug;
    use InteractsWithMedia;

    protected $appends = ['album_art'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getSearchResult(): SearchResult
    {
       $url = route('bundles.show', $this->id);

       return new SearchResult($this, $this->name, $url);
    }

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
        return $this->getFirstMedia('bundle_album_art') ? $this->getFirstMedia('bundle_album_art')->getUrl() : $this->large_image_path;
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
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
            'bundles.name' => 10,
        ],
        // 'joins' => [
        //     'categories' => ['products.id','categories.product_id'],
        //     'preacher' => ['products.id','preachers.product_id'],
        // ],
    ];
    
    public function orders() {
        return $this->belongsToMany(Order::class, 'bundle_order', 'bundle_id', 'order_id')->withPivot('products')->withTimestamps();
    }

}
