<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Mail\PasswordResetLinkMail;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('permission:create_user', ['only' => ['create','store']] );
        $this->middleware('permission:read_user', ['only' => ['index']] );
        // $this->middleware('permission:update_user', ['only' => ['update','edit']] );
        // $this->middleware('permission:delete_user', ['only' => 'destroy']);

        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        return view('backend.users.index-user', [
            'status' => $status,
            'all' => $this->userRepository->countAll(),
            'admin' => $this->userRepository->countByRole('Admin'),
            // 'user' => $this->userRepository->countByRole('User'),
            // 'editor' => $this->userRepository->countByRole('Editor'),
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        if ( $user->hasRole('Super Admin') ) {

            $roles = Role::pluck('name', 'name')->all();
        }
        else {

            $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();
        }

        return view('backend.users.create-user', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        // Check if the currently authenticated user is a Super Admin
        if ( !Auth::user()->hasRole('Super Admin') ) {

            $request->validate([
                // 'phone' => 'requiredunique:users,phone',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'roles' => 'required|array|exists:roles,name',
                'roles.*' => 'not_in:Super Admin',
            ], [
                'roles.*.not_in' => 'The Super Admin role cannot be assigned by non-Super Admin users.',
            ]);

        }

        $user = User::create([
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make( $request->password ),
        ]);

        if ( $user ) {

            $user->syncRoles( $request->roles );

            $this->userRepository->processMetaData($user, $request);
        }
        else {

            abort(403, 'User creation failed.');
        }

        session()->flash('success', 'User Created.');

        return redirect()->route('backend.user');
    }

    public function passwordResetLink(User $user)
    {
        // try {

            $user->remember_token = Str::random(64);
            $this->userRepository->updateOrCreateMeta($user, 'reset_password_time', time() );
            $user->save();

            Mail::to($user->email)->send(new PasswordResetLinkMail($user));

            session()->flash('success', 'Password Reset Link Sent..');

        // } catch (\Exception $e) {
        //     session()->flash('error', 'Failed To Send Link: ' . $e->getMessage());
        //     Log::error($e);
        // }

        return redirect()->back();
    }
}
