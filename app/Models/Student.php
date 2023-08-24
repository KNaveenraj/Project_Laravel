<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{

    use HasFactory;


    protected $fillable = ['name','email','phone','address','image','isAdmin'];

    protected $hidden = [
        'password',
        'remember_token',

    ];


}
