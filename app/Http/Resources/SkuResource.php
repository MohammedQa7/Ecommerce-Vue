<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productId' => $this->product_id,
            'code' => $this->code,
            'price' =>$this->price,
            'stock' => $this->stock,
            'variant' => VariantResource::collection($this->whenLoaded('variant'))
        ];
    }
}
