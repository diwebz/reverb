<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'res_no',
        'res_name',
        'res_count',
        'res_date',
        'res_time',
        'res_phone',
        'res_email',
        'res_notes',
        'res_status',
    ];
}
