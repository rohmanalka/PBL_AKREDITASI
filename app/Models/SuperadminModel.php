<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperadminModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_superadmin';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password'];

    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];
}
