<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Repository\Permission\PermissionRepository;

class PermissionSeeder extends Seeder
{
    protected $permissionRepository;

    function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view_users',
            'edit_users',

            'view_roles',
            'edit_roles',

            'view_permissions',
            'edit_permissions',

        ];
        //create define permissions
        foreach ($permissions as $permission) {
            $this->permissionRepository->model()::create(['name' => $permission]);
        }
    }
}