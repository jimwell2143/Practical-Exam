<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Jobs\SendUserEmailJob;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|unique:users',
            'password' => 'required|confirmed' 
        ];  

        $this->validate($request, $rules);

        $user = User::create($request->all());
        
        dispatch(new SendUserEmailJob($user));

        return $this->successResponse('User successfully registered', 201);
    }
}
