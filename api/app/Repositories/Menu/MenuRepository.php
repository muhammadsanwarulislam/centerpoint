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

    protected function applyDefaultCriteria($query)
    {
        parent::applyDefaultCriteria($query);
        $query->orderBy('created_at', 'desc');
    }

    protected function getSearchFields()
    {
        return ['name'];
    }
}