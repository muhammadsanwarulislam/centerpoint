<?php

namespace Repository\Role;
use Repository\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository {
    
    public function model()
    {
        return Role::class;
    }

    public function getRole()
    {
        return $this->model()::pluck('name','name')->all();
    }
}
