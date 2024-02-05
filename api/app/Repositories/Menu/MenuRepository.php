<?php 

namespace Repository\Menu;

use App\Models\Menu;
use Repository\BaseRepository;

class MenuRepository extends BaseRepository 
{
    public function model()
    {
        return Menu::class;
    }
}