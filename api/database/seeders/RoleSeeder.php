<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Repository\Role\RoleRepository;

class RoleSeeder extends Seeder
{
    protected $roleRepository;

    function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository   =  $roleRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Admin',
            'Editor',
            'Viewer'
        ];
        //create define roles
        foreach($roles as $role) {
            $this->roleRepository->model()::updateOrCreate([
                'name' => $role,
                'created_at'=> new \DateTime()
            ]);
        }
    }
}