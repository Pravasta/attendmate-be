<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // fillable
    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'latitude',
        'longitude',
        'note',
        'status',
    ];
}
