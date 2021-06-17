<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\News_Comment;
use App\Models\User;

class News extends Model
{
    protected $table = 'News';

    protected $fillable = [
        'Title',
        'Author'
    ];

    use HasFactory;

    public function News_Comment() { // FK relationship
        return $this->hasMany(News_Comment::class);
    }

    public function User() { // FK relationship
        return $this->belongsTo(User::class, 'Author');
    }
}
