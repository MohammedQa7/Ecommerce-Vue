<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validation
      if (Auth::check()) {
          dd(Auth::user()->currentAccessToken());
      }else{
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        // login
        $credintials = $request->only('email', 'password');
        if ($validated) {
            if (Auth::attempt($credintials)) {
                $token = Auth::user()->createToken('auth_token')->plainTextToken;
                dd($token);
            }else{
                dd('error in the creds');
            }
        }else{
            return response()->json('something went wrong');
        }
      }
        // it will only return the token only and only if the email and passowrd is already in the admins table
    }

    public function logout()
    {
        Auth::user();
    }
}