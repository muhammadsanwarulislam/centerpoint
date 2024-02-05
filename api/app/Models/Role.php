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

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
