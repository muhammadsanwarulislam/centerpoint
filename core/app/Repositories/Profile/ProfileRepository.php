<?php

namespace Repository\Profile;

use App\Models\Profile;
use Repository\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileRepository extends BaseRepository
{
    public function model()
    {
        return Profile::class;
    }

    public function findByUser($id)
    {
        return $this->model()::where('user_id', $id)->first();
    }

    public function updateProfileByID($id, array $modelData)
    {
        $profile = $this->model()::where('user_id', $id)->first();
         if($profile != null)
        {
            $profile->update($modelData);
        }else{
            return $this->model()::create($modelData);
        }
    }

    public function updateFile($id)
    {
        $userImage = $this->model()::where('user_id', $id)->first();
        if($userImage)
        {
            Storage::delete($userImage->image);
        }
    }

    public function storeFile(UploadedFile $file)
    {
        return Storage::put('fileuploads/user', $file);
    }
}