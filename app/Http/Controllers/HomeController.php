<?php

namespace App\Http\Controllers;

use App\Models\AttributeOptions;
use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function index()
    {
        $decoded_data = [];
        $iterator = 0;
        $attrbiute_options = AttributeOptions::with('attribute:name,id' , 'subOptions')->get()->groupBy('attribute');   
        foreach ($attrbiute_options as $key => $value) {
            $decoded_data [$iterator]['key'] = json_decode($key);   
            $decoded_data [$iterator]['value'] = $value;   
            $iterator++;
        }
        

        foreach ($decoded_data as $single_item) {
            foreach ($single_item['value'] as $single_value) {
            }
        }
        $products = Product::select('id', 'name')->paginate(4);
        // dd($products);
        return view('welcome')->with('products', $products);
    }

    public function store(Request $request)
    {
        $all_items = $request->items;
        $passExamFlag = false;
        foreach ($all_items as $single_item) {
            $product = Product::find($single_item['question_id']);
            if ($product->user_id != $single_item['user_answer']) {
                $passExamFlag =false;
                break;
            }else{
                $passExamFlag =true;
            }
        }
        if ($passExamFlag) {
            return response()->json(['message' => 'congrats you made it']);
        }else{
            return response()->json(['message' => 'sorry you failed the exam']);
        }
    }
}