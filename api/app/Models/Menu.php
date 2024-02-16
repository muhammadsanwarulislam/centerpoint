<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "label",
        "component",
        "ordering",
        "parent_id"
    ];
    public function menuItems()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function attachRolesToTheMenu()
    {
        return $this->belongsToMany(Role::class, 'menu_role_assignment');
    }
}
