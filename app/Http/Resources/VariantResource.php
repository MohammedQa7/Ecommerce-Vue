<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
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
            'Attribute' => new AttributeOptions($this->whenLoaded('attribute')),
            'subOptions' => AttributeSubOptions::collection($this->whenLoaded('subOptions')),
        ];
    }
}
