<?php

namespace App\Http\Resources\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"        => $this->id,
            "name"      => $this->name,
            "label"     => $this->label,
            "component" => $this->component,
            "ordering"  => $this->ordering,
            "parent_id" => $this->parent_id,
            "type"      => $this->type,
            "roles"     => $this->detachRolesToTheMenu,
        ];
    }
}
