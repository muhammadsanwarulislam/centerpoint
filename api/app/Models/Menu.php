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
    ];

    public function attachRolesToTheMenu()
    {
        return $this->belongsToMany(Role::class, 'menu_role_assignment');
    }
}
