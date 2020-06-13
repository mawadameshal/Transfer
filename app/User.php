<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable

{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','typeId','countryId', 'mobile','companyId','status','office_id','branch_id',
        'image'

    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function usertype()
    {
        return $this->belongsTo('App\User_Type', 'typeId');
    }

    public function country()
    {
        return $this->belongsTo('App\Country','countryId');
    }

    public function company()
    {
        return $this->belongsTo('App\Company','companyId');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch','branch_id');
    }

    public function office()
    {
        return $this->belongsTo('App\Office','office_id');
    }


    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('uploads/profile/' . $value);
        } else {
            return asset('uploads/profile/no-image.png');
        }
    }


}
