<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers($search = null, $sortColumn = 'created_at', $sortDirection = 'desc', $filters = [])
    {
        return User::search($search, ['name', 'email'])
            ->filter($filters)
            ->sort($sortColumn, $sortDirection)
            ->paginate(10);
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser($id, $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        return User::destroy($id);
    }
}
