<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'provider_id',
        'charging_time',
        'discount',
        'amount',
        'commission',
        'payment_method',
        'payment_status',
        'comment',
        'plug_type',
        'power',
        'per_min_cost',
        'request_status',
    ];

    public function customer()
    {
        return $this->hasOne('App\UserApp', 'id', 'customer_id');
    }
    public function vendor()
    {
        return $this->hasOne('App\UserApp', 'id', 'provider_id');
    }
    public function plugType()
    {
        return $this->hasOne('App\ChargerBox', 'id', 'plug_type');
    }
    public function status()
    {
        return $this->belongsToMany('App\Status','order_has_status','order_id','status_id')->withPivot('user_apps_id','created_at','comment')->orderBy('order_has_status.id','ASC');
    }

    public function laststatus()
    {
        return $this->belongsTo('App\OrderHasStatus','id', 'order_id');
    }
}
