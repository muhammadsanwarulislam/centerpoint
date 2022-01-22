<?php

namespace App\Http\Controllers\API\Backend;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\JsonResponseTrait;

class AuthController extends Controller
{
    use JsonResponseTrait;

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        // return response([ 'user' => $user, 'token' => $token]);
        return $this->json('User registered successfully',[
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return $this->bad('Invalid Credentials');
        }

        $token = auth()->user()->createToken('API Token')->accessToken;
        // return response(['user' => auth()->user(), 'token' => $token]);
        return $this->json('Login successfully', [
            'access_token'  => $token,
            'access_type'   => 'Bearer'
        ]);

    }
}
