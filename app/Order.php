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
}
