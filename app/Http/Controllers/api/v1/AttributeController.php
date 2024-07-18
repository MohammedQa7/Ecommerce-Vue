<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeValidationRequest;
use App\Models\Attribute;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    use ApiResponseTrait;
    public function store(AttributeValidationRequest $request)
    {
        $attribute  = Attribute::create([
            'name' => $request->name
        ]);

        if ($attribute) {
            return $this->Success('attribute has been successfully created.');
        }
    }
}
