<?php

namespace App\Livewire\Backend\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\UserService;

class IndexUser extends Component
{
    use WithPagination;
    
    public $perPage = 15;
    public $search = '';
    public $status = '';

    protected $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function mount($status = 'all')
    {
        $this->status = $status;
    }

    public function toggleSuspended($userId)
    {
        $result = $this->userService->toggleSuspended($userId);
        
        if (!$result['success']) {
            $this->dispatch('error', ['message' => $result['message']]);
            return;
        }

        $this->dispatch('success', ['message' => $result['message']]);
    }
    
    public function render()
    {        
        return view('livewire.backend.user.index-user', [
            'users' => $this->userService->getUserByStatus($this->status, $this->search)->paginate($this->perPage),
        ]);
    }
}
