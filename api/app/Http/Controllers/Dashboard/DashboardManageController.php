<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Traits\JsonResponseTrait;
use Repository\User\UserRepository;
use App\Http\Controllers\Controller;

class DashboardManageController extends Controller
{
    use JsonResponseTrait;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index(Request $request){
        return $this->successJsonResponse("Total users",$this->userRepository->getAllUsersWithRole());
    }
}
