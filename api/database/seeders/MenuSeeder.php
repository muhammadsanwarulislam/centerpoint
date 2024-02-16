<?php 

declare(strict_types=1);

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Repository\Menu\MenuRepository;
use Repository\Role\RoleRepository;

class MenuSeeder extends Seeder
{
    protected $roleRepository, $menuRepository;

    public function __construct(RoleRepository $roleRepository, MenuRepository $menuRepository) {
        $this->roleRepository = $roleRepository;
        $this->menuRepository = $menuRepository;
    }

    public function run() {
        // Retrieve the role IDs for the roles you want to assign to menus
        $admin = $this->roleRepository->getRoleIdByName(env('DEFAULT_ROLE_FOR_SEEDER'));
        $viewer = $this->roleRepository->getRoleIdByName(env('DEFAULT_ROLE'));
        // Define menus with their child menus, ordering information, and assigned roles
        $menus = [
            [
                "name"      => "Dashboard",
                "label"     => "List",
                "component" => "OverView",
                "ordering"  => 1,
                "roles"     => [$admin, $viewer],
            ],
            [
                "name"      => "User",
                "label"     => "List",
                "component" => "UserCreation",
                "ordering"  => 2,
                "roles"     => [$viewer],
            ],
            [
                "name"      => "Role",
                "label"     => "List",
                "component" => "RoleCreation",
                "ordering"  => 3,
                "roles"     => [$viewer],
            ],
            [
                "name"      => "Permission",
                "label"     => "List",
                "component" => "PermissionCreation",
                "ordering"  => 4,
                "roles"     => [$viewer],
            ],
            // Add more menus and their child menus as needed
        ];
    
        foreach ($menus as $menuData) {
            $menu = $this->menuRepository->model()::updateOrCreate(
                ["name" => $menuData['name']], 
                [
                    "label"     => $menuData['label'],
                    "component" => $menuData['component'],
                    "ordering"  => $menuData['ordering'],
                    "parent_id" => NULL,
                    "created_at"=> new \DateTime(),
                ]
            );

            // Attach roles to the menu
            $menu->attachRolesToTheMenu()->sync($menuData['roles']);
        }
    }
}