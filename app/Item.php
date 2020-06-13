<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable = [
     'ename', 'aname', 'category_id', 'sub_category_id', 'no_orders', 'status', 'image', 'edescription', 'description', 'suger_spons', 'quantity', 'extra_ice', 'temperature', 'featured'
    ];


    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Category', 'sub_category_id');
    }


}
