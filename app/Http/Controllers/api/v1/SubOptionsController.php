<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeOptions;
use App\Models\Sku;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class SubOptionsController extends Controller
{
    use ApiResponseTrait;
    public function store(Request $request)
    {
        if ($request->subOptions) {
            foreach ($request->subOptions as $single_subOption) {
                // we will recevie the sku code which will indicate the parent option for that sub option
                $parent_option = Sku::where('code', $single_subOption['sku_code'])->with('variant.subOptions')->first();
                // getting the parent option 
                $parent_option_id = $parent_option->variant[0];
                // creating the sub option as a seperate option
                $attribute = Attribute::where('name', $single_subOption['attribute_name'])->first();
                $sub_option_id = $attribute->attributeOptions()->create([
                    'value' => $single_subOption['sub_option_name']
                ]);
                if ($sub_option_id) {
                    // linking the the two options togather parentOption with subOption
                    $parent_option_id->subOptions()->attach($sub_option_id, [
                        'price' => $single_subOption['price'],
                        'stock' => $single_subOption['stock'],
                    ]);
                }
            }

        }
    }

    public function destroy($parent_option_id, $sub_option_id)
    {
        $parent_option = AttributeOptions::find($parent_option_id);
        $sub_option = AttributeOptions::find($sub_option_id);
        $delete_status = $parent_option->subOptions()->where('attribute_option_sub_id', $sub_option_id)->first()
            ? $parent_option->subOptions()->detach($sub_option)
            : $this->Failed('something wrong happend while deleting, please try again later or make sure you are deleting the correct sub option', 404);
        if ($delete_status) {
            return $this->Success( $sub_option->value. ' ' . 'Option has been deleted successfully');
        }
    }
}