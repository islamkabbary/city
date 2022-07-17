<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_addresses_id' => $this->user_addresses_id,
            'status' => $this->status,
            'added_tax_id' => $this->added_tax_id,
            'delivery_value_id' => $this->delivery_value_id,
            'company_id' => $this->company_id,
            'promo_code_id' => $this->promo_code_id,
            'phone' => $this->phone,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'created_at' => $this->created_at,
        ];
    }
}
