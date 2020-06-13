<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'ename', 'aname', 'father_id','image'
    ];


    public function subcategory()
    {
        return $this->hasMany('App\Category', 'father_id');
    }
}
