<?php 

declare(strict_types=1);

namespace Database\Seeders;

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
        $defaultRoleId = $this->roleRepository->findOrFailByID(env('DEFAULT_ROLE_FOR_SEEDER'))->id;
    
        // Define menus with their child menus and ordering information
        $menus = [
            [
                "name"      => "Dashboard",
                "label"     => "List",
                "component" => NULL,
                "ordering"  => 1,
                // "children"  => [
                //     ["name" => "Child Menu 1", "label"=>"List", "ordering" => 1],
                //     ["name" => "Child Menu 2", "label"=>"Create", "ordering" => 2],
                // ]
            ],
            [
                "name"      => "Settings",
                "label"     => "List",
                "component" => NULL,
                "ordering"  => 2,
                // "children"  => [
                //     ["name" => "Child Menu 3", "label"=>"List", "ordering" => 1],
                //     ["name" => "Child Menu 4", "label"=>"Create", "ordering" => 2],
                // ]
            ],
            [
                "name"      => "Over View",
                "label"     => "List",
                "component" => NULL,
                "ordering"  => 6,
                // "children"  => [
                //     ["name" => "Child Menu 5", "label"=>"List", "ordering" => 1],
                //     ["name" => "Child Menu 6", "label"=>"Create", "ordering" => 2],
                // ]
            ],
            // Add more menus and their child menus as needed
        ];
    
        foreach ($menus as $menuData) {
            // Create or update the parent menu
            $parentMenu = $this->menuRepository->model()::updateOrCreate(
                ["name" => $menuData['name']], 
                [
                    "label"     => $menuData['label'],
                    "component" => $menuData['component'],
                    "ordering"  => $menuData['ordering'],
                    "role_id"   => $defaultRoleId,
                    "parent_id" => NULL
                ]
            );
    
            // Create or update the child menus for this parent menu
            // foreach ($menuData['children'] as $childData) {
            //     $this->menuRepository->model()::updateOrCreate(
            //         ["name" => $childData['name']], 
            //         [
            //             "label"     => "List",
            //             "component" => NULL,
            //             "ordering"  => $childData['ordering'],
            //             "parent_id" => $parentMenu->id
            //         ]
            //     );
            // }
        }
    }
    
    
}