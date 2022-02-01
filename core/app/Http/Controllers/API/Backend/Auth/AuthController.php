<?php

namespace App\Http\Controllers\API\Backend\Auth;


use App\Models\User;
use Illuminate\Http\Request;
use Repository\User\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\JsonResponseTrait;

class AuthController extends Controller
{
    use JsonResponseTrait;

    protected $authRepo;

    function __construct(UserRepository $authRepo)
    {
        $this->authRepo   =  $authRepo;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);
        $user = $this->authRepo->create($request->all());

        return $this->json('User registered successfully',[
            'user' => $user,
            'access_token' => $this->authRepo->generateAccessToken($user),
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
    
        return $this->json('Login successfully', [
            'access_token'  => $this->authRepo->generateAccessToken($user = auth()->user()),
            'access_type'   => 'Bearer'
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->json('User logged out.',['type' => 'logout_success']);
    }

}
