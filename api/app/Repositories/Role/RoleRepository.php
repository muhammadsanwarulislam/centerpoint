<?php

namespace Repository\Role;
use App\Models\Role;
use Repository\BaseRepository;

class RoleRepository extends BaseRepository {
    
    public function model()
    {
        return Role::class;
    }

    public function defaultRole()
    {
        $this->model()::where('name', 'Viewer')->first();
    }
}
