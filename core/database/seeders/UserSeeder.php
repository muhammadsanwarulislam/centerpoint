<?php

namespace Database\Seeders;

use Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Muhammad', 
            'email' => 'super@gmail.com',
            'password' => Hash::make('secret')
        ]);
         
        $role = Role::find(1);

        $permissions = Permission::pluck('id', 'id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}
