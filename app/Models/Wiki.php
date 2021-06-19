<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Wiki_Contributor;
use App\Models\User;

class Wiki extends Model
{
    protected $table = 'Wiki';

    protected $fillable = [
        'Title',
        'Author'
    ];

    use HasFactory;

    public function Wiki_Contributor() { // FK relationship
        return $this->hasMany(Wiki_Contributor::class, 'Article');
    }

    /*public function User(){
        return $this->hasMany(Wiki_Contributor::class, 'Article')->belongsTo(User::class, 'Author');
    }*/

    public function User() { // FK relationship
        return $this->belongsTo(User::class, 'Author');
    }
}
