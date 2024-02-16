<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function getMenusAccordingToTheRoleId()
    {
        return $this->belongsToMany(Menu::class,'menu_role_assignment','role_id')->withPivot('role_id','menu_id','parent_id')->withTimestamps();
    }
}
