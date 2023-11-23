<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiRes;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return ApiRes::validatorError($errors);
        }
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = $req->password;
        $sattus = $user->save();
        if ($sattus) {
            return ApiRes::success("You register successfully !");
        } else {
            return ApiRes::error();
        }
    }
    public function login(Request $req)
    {
        if (!Auth::attempt($req->only('email', 'password'))) {
            return ApiRes::credentials();
        } else {
            $user = Auth::user();
            $token = $user->createToken($user->name)->plainTextToken;

            return ApiRes::login('You login successfully !', $token);
        }
    }
    public function data()
    {
        return ApiRes::data(auth()->user());
    }
    public function logout(Request $req)
    {

        $user =  $req->user()->currentAccessToken()->delete();
        if ($user) {

            return  ApiRes::logout('You logout successfully !');
        } else {
            return ApiRes::error();
        }
    }
}
