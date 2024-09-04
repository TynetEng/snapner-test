<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

use Tymon\JWTAuth\Contracts\JWTSubject;


class Project extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date', 'end_date'
    ];
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
