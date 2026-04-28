<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUserByStatus($status = 'all', $search = '')
    {
        $query = $this->repository->query();

        $currentUser = auth()->user();

        if (!$currentUser->hasRole('Super Admin')) {
            $query->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Super Admin');
            });
        }

         if ( $status !== 'all' ) $query->role($status);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('id', 'asc');

    }

    public function toggleSuspended($userId)
    {
        $user = $this->repository->getUserById($userId);
        
        if (!$user) {
            return [
                'success' => false,
                'message' => 'User not found.'
            ];
        }

        $currentUserId = auth()->id();
        
        // Prevent suspending current authenticated user
        if ($user->id == $currentUserId) {
            return [
                'success' => false,
                'message' => 'You cannot suspend yourself.'
            ];
        }

        // Prevent suspending user with ID 1
        if ($user->id == 1) {
            return [
                'success' => false,
                'message' => 'This user cannot be suspended.'
            ];
        }
        
        $result = $this->repository->toggleSuspended($userId);
        
        if ($result) {
            return [
                'success' => true,
                'message' => "User successfully {$result['status']}.",
                'user' => $result['user'],
                'status' => $result['status']
            ];
        }

        return [
            'success' => false,
            'message' => 'Failed to toggle suspension status.'
        ];
    }
}