<?php

namespace App\Policies;

use App\Models\AttributeOptions;
use App\Models\Product;
use App\Models\Sku;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AttributeOptionsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AttributeOptions $attributeOptions): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user , Product $product): bool
    {
        return ($user->id == Auth::user()->id && $product->user_id == Auth::user()->id);
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AttributeOptions $attributeOptions): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user , Sku $sku): bool
    {
        return ($user->id == Auth::user()->id && $sku->product->user_id == Auth::user()->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AttributeOptions $attributeOptions): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AttributeOptions $attributeOptions): bool
    {
        //
    }
}
