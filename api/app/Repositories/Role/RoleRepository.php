<?php

namespace Repository\Role;
use App\Models\Role;
use Repository\BaseRepository;

class RoleRepository extends BaseRepository {
    
    public function model()
    {
        return Role::class;
    }

    protected function applyDefaultCriteria($query)
    {
        parent::applyDefaultCriteria($query);
        $query->orderBy('created_at', 'desc');
    }

    protected function getSearchFields()
    {
        return ['name'];
    }

    public function getRoleIdByName($roleName = null)
    {
        $role =  $this->model()::select('id')->where('name', $roleName)->firstOrFail();
        return $role['id'];
    }
}
