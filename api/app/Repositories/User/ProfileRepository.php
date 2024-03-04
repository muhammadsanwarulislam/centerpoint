<?php

declare(strict_types=1);

namespace Repository\User;

use App\Models\Profile;
use Repository\BaseRepository;

class ProfileRepository extends BaseRepository
{

    public function model()
    {
        return Profile::class;
    }

    public function updateProfileByID($id, array $modelData)
    {
        // Check if the user exists
        $user = $this->model()::where('user_id', $id)->first();
        if (!$user) {
            return ['error' => 'User with the provided ID not found'];
        }
        // Update the profile
        $this->model()::where('user_id', $id)->update($modelData);
        // Retrieve the updated user data
        $updatedUser = $this->model()::where('user_id', $id)->first();
        // Return the updated user data
        return $updatedUser;
    }
}
