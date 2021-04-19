<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use app\Models\Forum;

class Forum_Comment extends Model
{
    use HasFactory;

    //protected $table = 'Forum_Comments';

    public function Forum() { // FK relationship
        return $this->belongsTo(Forum::class);
    }
}
