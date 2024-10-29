<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
class Intern extends Authenticatable implements CanResetPassword
{
    // Specify the table name (admins)
    protected $table = 'interns';

    // Allow these fields to be mass-assigned
    protected $fillable = [
        'intern_name',
        'intern_id',
        'email',
        'password',
    ];

    // Hide password from model output
    protected $hidden = [
        'password',
        'remember_token',
    ];
}