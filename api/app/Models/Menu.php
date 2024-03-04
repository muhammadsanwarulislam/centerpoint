<?php

namespace App\Models;

use App\Enums\CheckMenuTypeStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function getStatusAttribute($value)
    {
        return $value ? CheckMenuTypeStatusEnum::$value() : null;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['type'] = $value;
    }

    public function attachRolesToTheMenu()
    {
        return $this->belongsToMany(Role::class, 'menu_role_assignment');
    }

    public function detachRolesToTheMenu()
    {
        return $this->belongsToMany(Role::class,'menu_role_assignment','menu_id');
    }
}
