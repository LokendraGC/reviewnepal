<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function query()
    {
        return User::query();
    }
    
    public function getUserById($id)
    {
        if ( $id ) {
            $user = User::findOrFail( $id );
        }
        else {
            $user = User::findOrFail( Auth::user()->id );
        }

        return $user;
    }

    // check user is super admin or admin
    public function checkSuperAdminOrAdmin($authUser, $requestedUser)
    {
        if ( $authUser->hasRole('Super Admin') || ( $authUser->hasRole('Admin') && !$requestedUser->hasRole('Super Admin') ) ) {

            return true;
        }
        else {

            return false;
        }
    }

    public function processMetaData($user, $request)
    {
        $data = [];

        // $data['phone_number'] = $request->phone_number ?? null;

        foreach ($data as $key => $value) {
            $this->updateOrCreateMeta($user, $key, $value);
        }

        return true;
    }

    // update or create post meta
    public function updateOrCreateMeta($user, $key, $value)
    {
        $user->userMeta()->updateOrInsert(
            ['user_id' => $user->id, 'meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    public function countAll()
    {
        $currentUser = auth()->user();

        $query = User::query();

        if (!$currentUser->hasRole('Super Admin')) {
            $query->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            });
        }

        return $query->count();
    }

    public function countByRole($role)
    {
        return User::role($role)->count();
    }

    public function toggleSuspended($userId)
    {
        $user = User::find($userId);
        
        if (!$user) {
            return null;
        }

        if ($user->suspended_at) {
            $user->suspended_at = null;
            $status = 'unsuspended';
        } else {
            $user->suspended_at = now();
            $status = 'suspended';
        }

        $user->save();
        
        return [
            'user' => $user,
            'status' => $status
        ];
    }
}
