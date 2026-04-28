<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if ( Auth::check() ) {
            return redirect()->route('backend.dashboard');
        }
        else {
            return view('backend.auth.login');
        }
    }

    public function logout()
    {
        if ( Auth::check() ) {

            $user = User::findOrFail( Auth::user()->id);

            if ( $user ) {

                UserMeta::updateOrCreate(
                    ['user_id' => $user->id, 'meta_key' => 'last_login'],
                    ['meta_value' => now()]
                );

                Auth::logout();
            }
            else {
                Auth::logout();
            }
        }

        Auth::logout();

        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('backend.auth.forgot-password');
    }

    public function resetPassword($token)
    {
        $user = User::where('remember_token', '=', $token)->first();

        if ( !empty($user) ) {

            return view('backend.auth.reset-password', [
                'token' => $token,
            ]);

        } else {
            abort(404);
        }
    }
}
