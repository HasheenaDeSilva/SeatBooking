<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    // Specify the table name (admins)
    protected $table = 'admins';

    // Allow these fields to be mass-assigned
    protected $fillable = [
        'admin_name',
        'admin_id',
        'email',
        'password',
    ];

    // Hide password from model output
    protected $hidden = [
        'password',
        'remember_token',
    ];
}