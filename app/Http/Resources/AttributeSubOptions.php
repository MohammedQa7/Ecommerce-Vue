<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeSubOptions extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'price' => $this->pivot['price'],
            'stock' => $this->pivot['stock'],
            'Attribute' => new AttributeOptions($this->whenLoaded('attribute')),
        ];
    }
}
