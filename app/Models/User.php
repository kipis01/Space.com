<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Forum;
use App\Models\Forum_Comment;
use App\Models\News;
use App\Models\News_Comment;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Username',
        'email',
        'password',
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

    public function Forum(){
        return $this->hasMany(Forum::class);
    }

    public function Forum_Comment(){
        return $this->hasMany(Forum_Comment::class);
    }

    public function News(){
        return $this->hasMany(News::class);
    }

    public function News_Comment(){
        return $this->hasMany(News_Comment::class);
    }
}
