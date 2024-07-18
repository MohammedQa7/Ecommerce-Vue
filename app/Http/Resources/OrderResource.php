<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'orderID' => $this->id,
            'orderNumber' => $this->order_number,
            'userID' => $this->user_id,
            'totalPrice' => $this->total_price,
            'status' => $this->status,
            'variants'=> new VariantResource($this->whenLoaded('variants')),
            'subOptions'=> new VariantResource($this->whenLoaded('subOptions')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'createdAt' => $this->created_at->format('Y/m/d  :  h:i a'),
            'updatedAt' => $this->updated_at->format('Y/m/d  :  h:i a'),
        ];
    }
}
