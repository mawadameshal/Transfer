<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->order_date = Carbon::now()->format('Y-m-d');
            $model->order_time = Carbon::now()->format('H:i:s');
        });
    }

    protected $fillable = [
        'user_id_sender', 'user_id_receiver', 'deliver_to', 'deliver_at', 'order_date', 'order_time','status'
    ];


    public function sender()
    {
        return $this->belongsTo('App\User', 'user_id_sender');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'user_id_receiver');
    }

     public function OrderItems()
    {
        return $this->hasMany('App\OrderItems');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'order_items');
    }

    public function office()
    {
        return $this->belongsTo('App\Office', 'deliver_to');
    }

}
