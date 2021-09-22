<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Preacher as PreacherResource;
use App\Http\Resources\CategoryCollection;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'date_preached' => $this->date_preached,
            'unit_price' => $this->unit_price,
            'discount_price' => $this->discount_price,
            'quantity_per_unit' => $this->quantity_per_unit,
            'units_in_stock' => $this->units_in_stock,
            'units_on_order' => $this->units_on_order,
            'reorder_level' => $this->reorder_level,
            'is_taxable' => $this->is_taxable,
            'is_available' => $this->is_available,
            'is_discountable' => $this->is_discountable,
            'is_digital' => $this->is_digital,
            'is_active' => $this->is_active,
            'download_link' => $this->download_link,
            'large_image_path' => $this->large_image_path,
            'thumbnail_image_path' => $this->thumbnail_image_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                '_self' => route('api.products.show', $this->id),
                '_categories' => CategoryResource::collection($this->whenLoaded('categories')),
                '_preacher' => PreacherResource::collection($this->whenLoaded('preacher')),
            ]
        ];
    }
}
