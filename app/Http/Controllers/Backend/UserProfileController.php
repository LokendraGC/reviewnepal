<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // public function profile(Request $request)
    // {
    //     $authUser = Auth::user();

    //     $id = $request->route('id');

    //     $user = $this->userRepository->getUserById($id);

    //     if ( $this->userRepository->checkSuperAdminOrAdmin($authUser, $user) ) {

    //         $metaDatas = $user->userMeta->pluck('meta_value', 'meta_key')->toArray();


    //         if ( $authUser->hasRole('Super Admin') ) {

    //             $roles = Role::pluck('name', 'name')->all();
    //         }
    //         else {

    //             $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();

    //         }
    //         // $roles = Role::pluck('name', 'name')->all();
    //         $userRoles = $user->roles->pluck('name', 'name')->all();

    //         return view('backend.users.profile', [
    //             'user' => $user,
    //             'id' => $id,
    //             'metaDatas' => $metaDatas,
    //             'roles' => $roles,
    //             'userRoles' => $userRoles,
    //         ]);
    //     }
    //     else {
    //         $metaDatas = $user->userMeta->pluck('meta_value', 'meta_key')->toArray();


    //         if ( $authUser->hasRole('Super Admin') ) {

    //             $roles = Role::pluck('name', 'name')->all();
    //         }
    //         else {

    //             $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();

    //         }
    //         // $roles = Role::pluck('name', 'name')->all();
    //         $userRoles = $user->roles->pluck('name', 'name')->all();

    //         return view('backend.users.profile', [
    //             'user' => $user,
    //             'id' => $id,
    //             'metaDatas' => $metaDatas,
    //             'roles' => $roles,
    //             'userRoles' => $userRoles,
    //         ]);
    //     }
    // }
    public function profile(Request $request)
    {
        $authUser = Auth::user();

        $id = $request->route('id');

        $user = $this->userRepository->getUserById($id);

        if ( $this->userRepository->checkSuperAdminOrAdmin($authUser, $user) ) {

            $metaDatas = $user->userMeta->pluck('meta_value', 'meta_key')->toArray();


            if ( $authUser->hasRole('Super Admin') ) {

                $roles = Role::pluck('name', 'name')->all();
            }
            else {

                $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();

            }
            // $roles = Role::pluck('name', 'name')->all();
            $userRoles = $user->roles->pluck('name', 'name')->all();

            return view('backend.users.profile', [
                'user' => $user,
                'id' => $id,
                'metaDatas' => $metaDatas,
                'roles' => $roles,
                'userRoles' => $userRoles,
            ]);
        }

        abort(403, 'Unauthorized Access.');
    }

    public function store(Request $request, $id = NULL)
    {
        // Check if the currently authenticated user is a Super Admin
        if ( !Auth::user()->hasRole('Super Admin') ) {

            $request->validate([
                'roles' => 'array|exists:roles,name',
                'roles.*' => 'not_in:Super Admin',
            ]);
        }

        $authUser = Auth::user();

        $user = $this->userRepository->getUserById($id);

        if ( $this->userRepository->checkSuperAdminOrAdmin($authUser, $user) ) {

            $user->update([
                'name' => isset( $request->name ) ? $request->name : $user->name,
                // 'username' => $user->username,
                'email' => $request->email,
                // 'phone' => $request->phone,
                'password' => isset( $request->password ) ? Hash::make( $request->password ) : $user->password,
            ]);

            if ( $id && isset( $request->roles ) ) {

                $user->syncRoles( $request->roles );
            }

            $this->userRepository->processMetaData($user, $request);

            session()->flash('success', 'User Updated.');

            return redirect()->back();
        }

        abort(403, 'Unauthorized Access.');
    }

    public function deleteView(User $user)
    {
        if ( $user->hasRole('Super Admin') ) {
            abort(404);
        }

        $allUsers = User::query()
            ->whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['Super Admin', 'User']);
            })->get();

        return view('backend.users.delete-user-view', compact('user', 'allUsers') );
    }

    public function destroy(User $user, Request $request)
    {
        $validate = $request->validate([
            'delete_option' => 'required',
            'reassign_user' => 'required',
        ]);

        if ( $user->hasRole('Super Admin') ) {
            abort(404);
        }

        // Check the delete option selected by the user
        if ( $request->delete_option == 'delete_all_content' ) {

            // $user->posts()->forceDelete();

            // make as soft delete
            $user->forceDelete();

        }
        elseif ( $request->delete_option == 'attribute_all_content' ) {

            $reAssignUser = User::query()
                ->whereId($request->reassign_user)
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'User');
                })->first();

            if ( $reAssignUser ) {

                // Reassign all posts/content owned by the user
                $user->posts()->update(['user_id' => $reAssignUser->id]);

                // Reassign all media owned by the user
                $user->medias()->update(['user_id' => $reAssignUser->id]);

                $user->forceDelete();

            }

        }

        session()->flash('success', 'User Deleted.');

        return to_route('backend.user');

    }
}
