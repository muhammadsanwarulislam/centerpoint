<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Repository\Role\RoleRepository;
use Repository\User\UserRepository;

class UserSeeder extends Seeder
{
    function __construct(
        protected UserRepository $userRepository, 
        protected RoleRepository $roleRepository
    ) {}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define user data array
        $usersData = [
            [
                'email'     => 'super@gmail.com',
                'username'  => 'Muhammad',
                'password'  => 'password',
                'role_id'   => 1,
            ],
            [
                'email'     => 'admin@gmail.com',
                'username'  => 'Admin',
                'password'  => 'password',
                'role_id'   => 2,
            ],
            [
                'email'     => 'user@gmail.com',
                'username'  => 'User',
                'password'  => 'password',
                'role_id'   => 3,
            ],
        ];

        // Create users and profiles
        foreach ($usersData as $userData) {
            $user = $this->userRepository->model()::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'username' => $userData['username'],
                    'password' => $userData['password'],
                    'role_id' => $userData['role_id'],
                    'created_at' => now(),
                ]
            );
            if (!$user->profile) {
                $user->profile()->create([
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}