<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryMeta extends Model
{
    use HasFactory;

    protected $table = 'category_metas';

    protected $fillable = ['category_id', 'meta_key', 'meta_value'];

    protected $timestamp = false;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
