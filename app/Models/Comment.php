<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\CommentMeta;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['user_id', 'post_id', 'content', 'approved', 'type', 'comment_parent', 'comment_agent', 'comment_ip'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function commentMeta()
    {
        return $this->hasMany(CommentMeta::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'comment_parent');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'comment_parent');
    }
}
