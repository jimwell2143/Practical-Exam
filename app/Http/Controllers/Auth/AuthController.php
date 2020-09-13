<?php

namespace App\Http\Controllers\Auth;
use auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{
    
    public function login(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];  

        $this->validate($request, $rules);

        if ($this->hasTooManyLoginAttempts($request)){
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
    
        if($token = auth()->attempt(['email' => $request->email, 'password' => $request->password])){
           return response()->json([
               'access_token' => $token,
               'token_type' => 'Bearer'
           ], 201);
        }

        $this->incrementLoginAttempts($request);
        
        return $this->errorResponse('Invalid Credentials', 401);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return $this->successResponse('Successfully logout', 200);
    }

    
}
