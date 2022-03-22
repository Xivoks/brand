<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = [
        'user_id',
        'user_firstname',
        'user_lastname',
    ];
    public $timestamps = false;
}

