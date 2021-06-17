<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\News;
use App\Models\User;

class News_Comment extends Model
{
    protected $table = 'News_Comments';

    protected $fillable = [
        'Article',
        'Author',
        'Message'
    ];

    use HasFactory;

    public function News() { // FK relationship
        return $this->belongsTo(News::class);
    }

    public function User() { // FK relationship
        return $this->belongsTo(User::class, 'Author');
    }
}
