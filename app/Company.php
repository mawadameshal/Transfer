<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable =
        ['company_name', 'company_id', 'mobile', 'email', 'address',
            'logo', 'status', 'number_of_branches', 'number_of_offices'];

    public function branches()
    {
        return $this->hasMany('App\Branch');
    }

    public function offices()
    {
        return $this->hasMany('App\Office');
    }
}
