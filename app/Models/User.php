<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Like;
use App\Models\Post;
use App\Models\Media;
use App\Models\Category;
use App\Models\PollVote;
use App\Models\UserMeta;
use App\Models\Favourite;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'email_verified_at',
        'ip_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function before(User $user, string $ability): bool|null
    {
        if ( $user->hasRole('Super Admin') ) return true;

        return null;
    }

    public function userMeta()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    // mutator
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function lastLogin()
    {
        $lastLoginMeta = UserMeta::where('user_id', Auth::user()->id)
            ->where('meta_key', 'last_login')
            ->first();

        return $lastLoginMeta ? Carbon::parse( $lastLoginMeta->meta_value )->diffForHumans() : Carbon::parse(Auth::user()->updated_at)->diffForHumans();
    }

}
