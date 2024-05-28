<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestData extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'referrer',
        'language',
        'cookies',
        'plataforma',
        'navegador',
        'email',
        'phone',
        'name',
        'age',
        'so',
        'email_verified_at',
        'email_abierto',
    ];

    //protected $hidden=[];
}
