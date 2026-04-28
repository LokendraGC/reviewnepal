<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use App\Models\UserMeta;
use App\Helpers\UserHelper;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $rememberToken;

    #[Validate('required|confirmed')]
    public $password;

    #[Validate('required')]
    public $password_confirmation;

    public function mount($token)
    {
        $user = User::where('remember_token', '=', $token)->first();
        $resetPasswordTime = UserHelper::get_field('reset_password_time', $user);
        $currentTimestamp = time();
        $tokenValidityPeriod = 10 * 60;
        $tokenAge = $currentTimestamp - $resetPasswordTime;

        if ( $tokenAge <= $tokenValidityPeriod ) {

            if ( !empty($user) ) {

                $this->rememberToken = $token;

            } else {
                abort(403, 'User Not Found');
            }

        }
        else {

            abort(403, 'Reset link has been expired.');

        }
    }

    public function resetPassword()
    {
        $this->validate();

        if ( $this->password == $this->password_confirmation ) {

            $user = User::where('remember_token', '=', $this->rememberToken)->first();
            $user->password = Hash::make($this->password);
            $user->remember_token = NULL;
            $user->save();

            $this->dispatch('success', [ 'message' => 'Password Reset Successfully.' ]);

            $user->userMeta()->updateOrInsert(
                ['user_id' => $user->id, 'meta_key' => 'reset_password_time'],
                ['meta_value' => NULL]
            );

            return $this->redirectRoute('login');
        }
        else {

            $this->dispatch('success', [ 'error' => 'Password and Confirm Password does not match.' ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
