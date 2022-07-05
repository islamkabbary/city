<?php

namespace App\Http\Resources;

use App\Models\AdditionalInformation;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'price' => $this->price,
            'company' => $this->company,
            'status' => $this->status,
            'description' => $this->description,
            'Additional Information' =>$this->informations,
        ];
    }
}
