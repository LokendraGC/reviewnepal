<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentMeta extends Model
{
    protected $table = 'comment_metas';

    protected $fillable = ['comment_id', 'meta_key', 'meta_value',];

    public $timestamps = false;

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
