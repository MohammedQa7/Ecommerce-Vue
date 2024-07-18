<?php

namespace App\Traits;


/**
 * 
 */
trait ApiResponseTrait
{


    function ErrorStatus($message = "", $error_number = 'S000')
    {
        return response()->json([
            'Status' => false,
            'Msg' => $message,
            'errorNum' => $error_number,
        ]);
    }

    function Success($message = "")
    {
        return response()->json([
            'message' => $message,
            'status' => 200,
        ]);
    }

    function PaymentSuccess($message = "")
    {
        return response()->json([
            'message' => $message,
            'status' => 200,
        ]);
    }

    function Failed($message, $error_number)
    {
        return response()->json([
            'message' => $message,
            'status' => $error_number
        ]);
    }
}