<?php 

namespace Repository\MenuItem;
use App\Models\MenuItem;
use Repository\BaseRepository;

class MenuItemRepository extends BaseRepository
{
    public function model()
    {
        return MenuItem::class;
    }
}