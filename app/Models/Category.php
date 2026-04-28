<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\CategoryMeta;
use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory, SoftDeletes;

    // public $timestamps = false;

    protected $fillable = ['user_id', 'name', 'slug', 'type', 'description', 'parent', 'parent_id_backup', 'menu_order', 'last_updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    // Define the relationship with the parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent');
    }

    // Define the relationship with the children categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function categoryMeta()
    {
        return $this->hasMany(CategoryMeta::class, 'category_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    // scopes
    public function scopeCategoryType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeGetAllMetaData($query)
    {
        return $this->categoryMeta->pluck('meta_value', 'meta_key')->toArray();
    }
}
