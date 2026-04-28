<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [ 'user_id', 'file_name', 'file_original_name', 'file_size', 'extension', 'type', 'alt', 'caption', 'description', 'metadata'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
