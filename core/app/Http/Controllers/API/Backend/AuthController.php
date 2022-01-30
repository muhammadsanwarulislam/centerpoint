<?php

namespace App\Http\Controllers\API\Backend;

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

        return $this->json('User registered successfully',[
            'user' => $user,
            'access_token' => $token,
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

        return $this->json('Login successfully', [
            'access_token'  => $token,
            'access_type'   => 'Bearer'
        ]);

    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();

            return $this->json([
                'type' => 'logout_success',
                'message' => 'User logged out.'
            ]);
        } catch (Exception $e) {
            return $this->bad('Fail to logged out',['exception' => $e]);
        }
    }

}
