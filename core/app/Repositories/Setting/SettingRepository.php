<?php
namespace Repository\Setting;

use App\Models\Setting;
use Repository\BaseRepository;

class SettingRepository extends BaseRepository {
    
    public function model()
    {
        return Setting::class;
    }
}