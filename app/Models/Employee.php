<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens, SoftDeletes;

    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use Notifiable;

    protected $guard = 'employee';


    protected $fillable = [
        'name',
        'email',
        'position',
        'password',
        'project_id'
    ];

    // public function project()
    // {
    //     return $this->belongsTo(Project::class,'product_id', 'id');
    // }

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}


