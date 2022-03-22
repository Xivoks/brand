<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estates extends Model
{
    use HasFactory;
    protected $table = 'estates';
    protected $fillable = [
        'supervisor_user_id',
        'street',
        'building_number',
        'city',
        'zip',
    ];
    public $timestamps = false;
}
