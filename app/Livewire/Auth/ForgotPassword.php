<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class ForgotPassword extends Component
{
    public $email;

    public function forgotPassword()
    {
        $user = User::where('email', '=', $this->email)->first();


        if ( !empty($user) ) {

            $user->remember_token = Str::random(32);

            $user->save();

            $this->email = '';

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            $this->dispatch('success', [ 'message' => 'Please Check Your Email and Reset Your Password.' ]);

            $user->userMeta()->updateOrInsert(
                ['user_id' => $user->id, 'meta_key' => 'reset_password_time'],
                ['meta_value' => time()]
            );

        } else {
            $this->dispatch('error', [ 'message' => 'Email Address Not Found.' ]);
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
