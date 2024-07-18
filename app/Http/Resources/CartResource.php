<?php

namespace App\Http\Resources;

use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $selected_sku = Sku::with([
            'variant.subOptions' => function ($query) {
                if (!is_null($this->sub_option_id)) {
                    $query->where('id', $this->sub_option_id);
                }
            }
         ,  'variant.attribute', 'variant.subOptions.attribute'])
        ->where('code', $this->sku_code)
        ->first();

        return [
            'id' => $this->id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'sku' => new SkuResource($selected_sku),
            // 'SubOptions' => AttributeSubOptions::collection($this->whenLoaded('options')),
            'quantity' => $this->quantity,
            'totalPrice' => $this->total_price
        ];
    }
}