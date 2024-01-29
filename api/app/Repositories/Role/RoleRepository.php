<?php

namespace Repository\Role;
use App\Models\Role;
use Repository\BaseRepository;

class RoleRepository extends BaseRepository {
    
    public function model()
    {
        return Role::class;
    }

    function modelName() : String 
    {
        return "Role::class";
    }

    public function defaultRoleID($roleName = null)
    {
        $role =  $this->model()::select('id')->where('name', $roleName)->firstOrFail();
        return $role['id'];
    }
}
