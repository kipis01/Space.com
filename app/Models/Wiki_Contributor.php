<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Wiki;
use App\Models\User;

class Wiki_Contributor extends Model
{
    protected $table = 'Wiki_Contributors';
    use HasFactory;

    public function Wiki() { // FK relationship
        return $this->belongsTo(Wiki::class);
    }

    public function User() { // FK relationship
        return $this->belongsTo(User::class);
    }
}
