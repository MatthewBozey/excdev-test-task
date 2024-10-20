<?php

namespace App\Http\Controllers;

use App\Facades\ApiSuccess;
use App\Http\Response\ApiErrorResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            auth()->user()->tokens()->where('name', 'api')->delete();
            $token = auth()->user()->createToken('api', ['users:list']);

            return ApiSuccess::withData(compact('token'));
        } else {
            return new ApiErrorResponse('Неверный логин или пароль');
        }

    }
}
