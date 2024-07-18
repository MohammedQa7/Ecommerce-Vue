<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rated_user  = User::where('id' , $this->pivot['user_id'])->first();
        return [
            'user' => new UserResource($rated_user),
            'rating' => $this->pivot['rating'],
            'message' => $this->pivot['message'],
            'created_at' => $this->pivot['created_at']->format('M d Y   h:i a'),
        ];
    }
}
