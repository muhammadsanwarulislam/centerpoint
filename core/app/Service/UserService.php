<?php

namespace App\Service;

use Repository\Role\RoleRepository;
use Repository\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $superAdminRepo;
    protected $roleRepo;

    public function __construct(
        UserRepository $superAdminRepository,
        RoleRepository $roleRepository
    ) {
        $this->superAdminRepo   =  $superAdminRepository;
        $this->roleRepo         =  $roleRepository;
    }

    public function createUser()
    {
        $input = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'roles' => 'required'
        ]);

        $input['password'] = Hash::make($input['password']);

        $this->superAdminRepo->superAdminUserCreate($input);

        return 'user created successfully';
    }

    public function getUserEditInfo($id)
    {
        $user = $this->superAdminRepo->getUserInfoById($id);
        return [
            'user' => $user,
            'roles' => $this->roleRepo->getRole(),
            'userRole' => $user->roles->pluck('name', 'name')->all()
        ];
    }
}
