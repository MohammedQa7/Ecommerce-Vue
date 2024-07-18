<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this;
        $overall_rating = 0;

        $total_rating = count($this->rating);

        foreach ($product->rating as $single_rating) {
            $overall_rating += $single_rating->pivot->rating;
        }


        return [
            'id' => $this->id,
            'name' => Str::limit($this->name, 20),
            'description' => $this->description,
            'slug' => $this->slug,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'user' => new UserResource($this->whenLoaded('user')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'skus' => SkuResource::collection($this->whenLoaded('sku')),
            'rating' => RatingResource::collection($this->whenLoaded('rating')),
            // 'skus' => $this->sku->map(function ($sku) {
            //     return [
            //         'sku_code' => $sku->code,
            //         'variants' => $this->groupVariantsByAttribute($sku->variant)
            //     ];
            // }),
            // 'variant2' => $this->load('sku.variant.attribute'),
            'createdAt' => $this->created_at,
            'is_favorited' => $this->is_favorited(Auth::user()->id ?? null),
            'isProductRatedByLoggedInUser' => Auth::user() ? ['user'=>Auth::user()->id,'isRated' =>$this->isProductRatedByUser()] : 'N/A',
            'overall_rating' => [
                'overall' => $total_rating != 0 ? round($overall_rating / $total_rating , 2) : '0.0',
                'ratingCount' => $total_rating
            ],
            'percentageRating' => $this->percentageRating
        ];
    }
// protected function groupVariantsByAttribute($variants)
// {
//     $groupedVariants = [];

//     foreach ($variants as $variant) {
//         $attributeName = $variant->attribute->name;

//         if (!array_key_exists($attributeName, $groupedVariants)) {
//             $groupedVariants[$attributeName] = [];
//         }

//         $groupedVariants[$attributeName][] = [
//             'variant_name' => $variant->name,
//             'variant_value' => $variant->value,
//         ];
//     }

//     return $groupedVariants;
// }
}