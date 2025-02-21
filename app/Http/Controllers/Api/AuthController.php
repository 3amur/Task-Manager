<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    // register api method
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:30',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }
        $data = $request->all();
        $user = User::create($data);
        // create user token
        $success['token'] = $user->createToken('MyTask')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User Registered Successfully !');
    }
    // login api method
    public function login(Request $request){
        // dd($request->all());
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyTask')->plainTextToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, "Welcome $user->name");
        }
        return $this->sendError('Wrong Credintials', ['error' => 'Unthorized']);
    }
}
