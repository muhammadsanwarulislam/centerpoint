<?php

namespace Repository\Permission;
use App\Models\Permission;
use Repository\BaseRepository;

class PermissionRepository extends BaseRepository {
    public function model()
    {
        return Permission::class;
    }
}