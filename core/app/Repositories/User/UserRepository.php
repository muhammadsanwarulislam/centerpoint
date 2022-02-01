<?php

namespace Repository\User;

use App\Models\User;
use App\Models\Profile;
use Repository\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRepository extends BaseRepository
{

    public function model()
    {
        return User::class;
    }

    public function getAllForAdmin()
    {
        return $this->model()::whereNotIn('name', ['Super Admin'])->get();
    }

    public function generateAccessToken(User $user): string
    {
        return $user->createToken('authToken')->accessToken;
    }

    public function updateOrNewBy(User $user, array $profileData = []): Profile
    {
        if ($profile = $user->profile) {
            $profile->update($profileData);
            return $profile->refresh();
        }
        return $user->profile()->create($profileData);
    }
}
