<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Wiki;
use App\Models\User;

class Wiki_Contributor extends Model
{
    protected $table = 'Wiki_Contributors';

    protected $fillable = [
        'Article',
        'Contributor',
        'Version'
    ];

    use HasFactory;

    public function Wiki() { // FK relationship
        return $this->belongsTo(Wiki::class, 'Article');
    }

    public function User() { // FK relationship
        return $this->belongsTo(User::class, 'Contributor');
    }
}
