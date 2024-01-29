<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Repository\Role\RoleRepository;
use Repository\Permission\PermissionRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    protected $roleRepository, $permissionRepository;

    function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = $this->permissionRepository->getAllPermissionsForSeeder();
        $admin = $this->roleRepository->model()::where('name','=','Admin')->first();
        foreach($permissions as $permission) 
        {
            DB::table('role_permission')->insert([
                'role_id'       => $admin->id,
                'permission_id' => $permission->id
            ]);
        }

        $editor = $this->roleRepository->model()::where('name','=','Editor')->first();
        foreach($permissions as $permission) 
        {
            if(!in_array($permission->name,['edit_roles'])) {
                DB::table('role_permission')->insert([
                    'role_id'       => $editor->id,
                    'permission_id' => $permission->id
                ]);
            }
        }

        $viewer = $this->roleRepository->model()::where('name','=','Viewer')->first();
        $viewRoles = [
            'view_users',
            'view_roles',
            'view_permissions'
        ];
        foreach($permissions as $permission) 
        {
            if(in_array($permission->name,$viewRoles)) {
                DB::table('role_permission')->insert([
                    'role_id'       => $viewer->id,
                    'permission_id' => $permission->id
                ]);
            }
        }
    }
}
