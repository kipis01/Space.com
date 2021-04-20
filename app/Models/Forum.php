<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Forum_Comment;
use App\Models\User;

class Forum extends Model
{
    use HasFactory;
    protected $table = 'Forum';

    public function Forum_Comment() { // FK relationship
        return $this->hasMany(Forum_Comment::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

}
