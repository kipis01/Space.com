<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use app\Models\Forum_Comment;

class Forum extends Model
{
    use HasFactory;
    protected $table = 'Forum';

    public function Forum_Comment() { // FK relationship
        return $this->hasMany(Forum_Comment::class);
    }

}
