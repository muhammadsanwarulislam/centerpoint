<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Repository\Role\RoleRepository;
use Repository\User\UserRepository;

class UserSeeder extends Seeder
{
    protected $userRepository, $roleRepository;

    function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository   =  $userRepository;
        $this->roleRepository   =  $roleRepository;
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->userRepository->model()::create([
            'username'  => 'Muhammad', 
            'email'     => 'super@gmail.com',
            'password'  => 'password',
            'role_id'   => $this->roleRepository->model()::inRandomOrder()->first()->id
        ]);

        $this->userRepository->model()::create([
            'username'  => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => 'password',
            'role_id'   => $this->roleRepository->model()::inRandomOrder()->first()->id
        ]);
        
        $this->userRepository->model()::create([
            'username'  => 'User',
            'email'     => 'user@gmail.com',
            'password'  => 'password',
            'role_id'   => $this->roleRepository->model()::inRandomOrder()->first()->id
        ]);
    }
}
