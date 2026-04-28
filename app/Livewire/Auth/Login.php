<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Validate('required')]
    public $email;

    #[Validate('required')]
    public $password;

    public $remember;

    public function login()
    {
        $this->validate();

        if (
            Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember) 
            // ||
            // Auth::attempt(['username' => $this->email, 'password' => $this->password], $this->remember)
        ) {
            // Check if authenticated user has the role 'User'
            $authenticatedUser = Auth::user();
            if ($authenticatedUser->hasRole('User')) {
                Auth::logout(); // Log out the user immediately
                abort(403, 'Access denied. Unauthorized Access.');
            }
            // If user passes the role check
            $this->dispatch('success', ['message' => 'Login Successfully.']);
            return $this->redirectRoute('backend.dashboard');
        } else {
            $this->dispatch('error', ['message' => 'Invalid Credentials.']);
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
