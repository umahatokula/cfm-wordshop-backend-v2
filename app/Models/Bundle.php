<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Bundle extends Model implements Searchable
{
    use SearchableTrait;
    use HasSlug;

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
