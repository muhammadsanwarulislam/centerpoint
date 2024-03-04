<?php

namespace Repository\Permission;
use App\Models\Permission;
use Repository\BaseRepository;

class PermissionRepository extends BaseRepository {
    public function model()
    {
        return Permission::class;
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

    function getAllPermissionsForSeeder() 
    {
        return $this->model()::all();
    }
}