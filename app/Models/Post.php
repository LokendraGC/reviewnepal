<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\PostMeta;
use App\Models\Favourite;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'post_title', 'slug', 'post_content', 'post_excerpt', 'post_status', 'post_parent', 'post_type', 'comment_status', 'menu_order', 'post_password', 'last_updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Define the relationship with the parent category
    public function parent()
    {
        return $this->belongsTo(Post::class, 'post_parent');
    }

    // Define the relationship with the children categories
    public function children()
    {
        return $this->hasMany(Post::class, 'post_parent');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // public function authors()
    // {
    //     return $this->categories()->where('type', 'author');
    // }

    public function postMeta()
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }

    // mutator
    // public function setPostTitleAttribute($value)
    // {
    //     $this->attributes['post_title'] = ucwords($value);
    // }

    // local scopes
    public function scopePostType($query, $type)
    {
        return $query->where('post_type', $type);
    }

    public function scopePostStatus($query, $status)
    {
        return $query->where('post_status', $status);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('post_title', 'like', "%{$value}%")->orWhere('slug', 'like', "%{$value}%");
    }

    // get all post meta data
    public function scopeGetAllMetaData($query)
    {
        return $this->postMeta->pluck('meta_value', 'meta_key')->toArray();
    }


    // get specific post meta data
    public function scopeGetMetaData($query, $key)
    {
        return $query->whereHas('postMeta', function ($query) use ($key) {
            $query->where('meta_key', $key)->whereNotNull('meta_value');
        });
    }

    // v2
    #[Scope]
    protected function postType(Builder $query, string $postType): void
    {
        $query->where('post_type', $postType);
    }

    #[Scope]
    protected function postStatus(Builder $query, string $postStatus): void
    {
        $query->where('post_status', $postStatus);
    }
}
