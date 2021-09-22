<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderDetail as OrderDetailResource;

class Order extends JsonResource
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
             'customer_id' => $this->customer_id,
             'order_number' => $this->order_number,
             'payment_id' => $this->payment_id,
             'amount' => $this->amount,
             'error_msg' => $this->error_msg,
             'is_fulfilled' => $this->is_fulfilled,
             'order_details' => OrderDetailResource::collection($this->whenLoaded('order_details')),
             'created_at' => $this->created_at,
             'updated_at' => $this->updated_at,
         ];
    }
}
