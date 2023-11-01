<?php
declare(strict_types=1);

namespace App\Http\Controllers\Core\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Repository\User\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\JsonResponseTrait;
use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\RegistrationPostRequest;

class AuthController extends Controller
{
    use JsonResponseTrait;

    protected $userRepository;

    function __construct(UserRepository $userRepository)
    {
        $this->userRepository   =  $userRepository;
    }

    public function register(RegistrationPostRequest $request)
    {
        //create user with validated the data in RegistrationPostRequest
        $user = $this->userRepository->create($request->validated()+[
            'role_id' => '2'
        ]);

        return $this->json('User registered successfully',[
            'user'          => $user,
            //generate access token to the created user
            'access_token'  => $this->userRepository->generateAccessToken($user), 
        ]);
    }

    public function authorizedUserInformation()
    {
        return Auth::user() ;
    }
    
    public function login(LoginPostRequest $request)
    {

        if(!auth()->attempt($request->validated()))
        {
            return $this->bad('Invalid Credentials');
        }

        return $this->json('Login successfully', [
            //generate access token to the logedIn user
            'access_token'  => $this->userRepository->generateAccessToken(auth()->user()),
            'access_type'   => 'Bearer',
            'user'          => auth()->user(),
            'permissions'   => $this->userRepository->getLoggedINUserPermissions(Auth::user()->id)
        ]);
    }

    public function loggedINUserPermissions()
    {
        $permissions = $this->userRepository->getLoggedINUserPermissions(Auth::user()->id);
        return $this->json('Logged in user permissions',[
            'permissions' => $permissions
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return $this->json('User logged out');   
    }

}
